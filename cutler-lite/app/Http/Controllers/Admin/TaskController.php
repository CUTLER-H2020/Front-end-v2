<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllTask;
use App\Models\NewWidget;
use App\Models\Policy;
use App\Models\Process;
use App\Models\ProcessDesignDateFilter;
use App\Models\ProcessImage;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\Widget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->page['title'] = 'Tasks';
        $this->page['sub_title'] = '';
    }

    public function index(Request $request, $xmlProcessId, $xmlInstanceId)
    {
        //$process = Process::whereXmlProcessId($xmlProcessId)->first();
        $process = Process::whereXmlInstanceId($xmlInstanceId)->first();
        newAnalytics($request, 'Tasks Page', "page_transition", Session::get('policyName'), $process->xml_process_name);
        $this->page['sub_title'] = $process->xml_process_name . ' Process Active Tasks';
        $allTasks = AllTask::whereInstanceId($xmlInstanceId)->orderBy('xml_task_name', 'asc')->get();
//        $completedTask = AllTask::whereUserId(Auth::user()->id)->whereInstanceId($xmlProcessId)->where('status', 0)->get();
        $task = Task::whereInstanceId($xmlInstanceId)->first();

        $processImage = ProcessImage::where('process_id', $xmlProcessId)->first();

        return view('admin.task.index', compact('task', 'allTasks', 'process', 'processImage', 'xmlProcessId', 'xmlInstanceId'))->with('page', $this->page);
    }

    public function show(Request $request, $xmlTaskId, $xmlProcessId, $xmlTaskName)
    {
        $task = Task::whereXmlTaskId($xmlTaskId)->first();
        if ((Auth::user()->group->name != 'Pilot Administrators') && (Auth::user()->group->name != $task->assignee) && ($task->assignee != 'allgroup')) {
            session_error(trans('translation.general.task.assign-error') . $task->assignee);
            return redirect()->route('task.index', ['xmlProcessId' => $xmlProcessId, 'xmlInstanceId' => $task->instance_id]);
        } else {
            //$process = Process::whereXmlProcessId($xmlProcessId)->first();
            $process = Process::whereXmlInstanceId($task->instance_id)->first();

            newAnalytics($request, 'Task Show', 'page_transition', Session::get('policyName'), $process->xml_process_name, $task->xml_task_name, $task->phase);
            //$widgets = Widget::where('task_name', $request->xmlTaskName)->get();
            $allTasks = AllTask::whereInstanceId($task->instance_id)->orderBy('xml_task_name', 'asc')->get();
            $widget = NewWidget::whereXmlProcessId($xmlProcessId)->whereTaskName($xmlTaskName)->first();

            $processImage = ProcessImage::where('process_id', $xmlProcessId)->first();
            //dd($allTasks);

            /* Get Rendered Form */
            $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task/" . $xmlTaskId . "/rendered-form";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            //curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/xhtml+xml'
            ));

            $renderedForm = curl_exec($ch);

            if ($renderedForm != '') {
                $action = route('task.submitFormAndNextTask', ['taskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'processName' => $task->process_name, 'instanceId' => $task->instance_id]);
                $renderedForm = str_replace('name="generatedForm"', 'name="generatedForm" id="generatedForm" action="' . $action . '" method="POST"', $renderedForm);
                $renderedForm = str_replace('</form>', csrf_field() . '</form>', $renderedForm);
            }
            $renderedFormStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //dd($renderedForm);
            curl_close($ch);

            //dd($httpcode);
            //$completeResult = json_decode($result, true);

            //dd($renderedForm);
            /* Get Rendered Form */

            $policy = Policy::where('id', $process->policy_id)->first();
            $taskComments = TaskComment::whereInstanceId($task->instance_id)->whereXmlProcessId($xmlProcessId)->get();
            $taskDateFilter = ProcessDesignDateFilter::whereTaskName($xmlTaskName)->whereXmlProcessId($xmlProcessId)->first();

            return view('admin.task.show', compact('widget', 'task', 'allTasks', 'xmlProcessId', 'processImage', 'renderedForm', 'renderedFormStatusCode', 'process', 'policy', 'taskComments', 'taskDateFilter'))->with('page', $this->page);
        }
    }

    public function finish(Request $request, $taskId, $xmlProcessId, $processName, $instanceId)
    {
        $process = Process::whereXmlProcessId($xmlProcessId)->first();
        $task = Task::whereXmlTaskId($taskId)->first();
        newAnalytics($request, 'Task Finish', 'system', Session::get('policyName'), $process->xml_process_name, $task->xml_task_name);
        $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task/" . $taskId . "/complete";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $completeResult = json_decode($result, true);

//        if ($task->last_task == 1) {
//            Process::whereXmlInstanceId($instanceId)->first()->update(['completed' => 1, 'completed_at' => Carbon::now()]);
//            session_success( trans('translation.general.task.process-complete'));
//        }

        AllTask::whereXmlTaskName($task->xml_task_name)->whereInstanceId($task->instance_id)->first()->update(["status" => 2, "phase" => $task->phase, "finished_at" => Carbon::now()]);
        Task::whereXmlTaskId($taskId)->delete();
        Widget::where('task_name', $task->xml_task_name)->delete();
        sleep(2);

        $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $tasksResultRows = json_decode($result, true);
        if (!is_null($tasksResultRows)) {
            foreach ($tasksResultRows as $row) {
                if ($row['processInstanceId'] == $instanceId) {
                    $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task/" . $row['id'] . "/variables";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $jsonDecodeSuccess = json_decode($result, true);

                    if (isset($jsonDecodeSuccess['end'])) {
                        $last_task = 1;
                    } else {
                        $last_task = 0;
                    }

                    if (isset($jsonDecodeSuccess['kafka'])) {
                        $kafka = 1;
                    } else {
                        $kafka = 0;
                    }

                    if (isset($jsonDecodeSuccess['maps'])) {
                        $maps = 1;
                    } else {
                        $maps = 0;
                    }

                    if (isset($jsonDecodeSuccess['link1'])) {
                        $link1 = 1;
                    } else {
                        $link1 = 0;
                    }

                    if (isset($jsonDecodeSuccess['link2'])) {
                        $link2 = 1;
                    } else {
                        $link2 = 0;
                    }

                    if (isset($jsonDecodeSuccess['link3'])) {
                        $link3 = 1;
                    } else {
                        $link3 = 0;
                    }

                    $task = new Task();
                    $task->user_id = Auth::user()->id;
                    $task->assignee = $row['assignee'];
                    $task->xml_definition_id = $row['processDefinitionId'];
                    $task->xml_task_name = $row['name'];
                    $task->xml_task_id = $row['id'];
                    $task->xml_process_id = $xmlProcessId;
                    $task->process_name = $processName;
                    $task->instance_id = $row['processInstanceId'];
                    $task->phase = $jsonDecodeSuccess['phase']['value'];
                    $task->description = $jsonDecodeSuccess['description']['value'];
                    $task->last_task = $last_task;
                    $task->kafka = $kafka;
                    $task->maps = $maps;
                    $task->link1 = $link1;
                    $task->link2 = $link2;
                    $task->link3 = $link3;
                    $task->save();
                    AllTask::whereXmlTaskName($task->xml_task_name)->whereInstanceId($task->instance_id)->first()->update(["started_at" => Carbon::now(), "status" => 1, "phase" => $task->phase]);
                }
            }
            /*
            $completedTaskCount = AllTask::whereInstanceId($instanceId)->whereStatus(2)->count();
            if ($completedTaskCount == $process->allTasks->count()){
                Process::whereXmlInstanceId($instanceId)->first()->update(['completed' => 1]);
                session_success("Process Completed");
            }
            */
        }

        $url = "http://". $this->getSetting()->camunda_ip .":" . $this->getSetting()->camunda_port . "/engine-rest/history/process-instance/". $instanceId;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $completeResult = json_decode($result, true);

        if ($completeResult['state'] == "COMPLETED"){
            Process::whereXmlInstanceId($instanceId)->first()->update(['completed' => 1, 'completed_at' => Carbon::now()]);
            session_success( trans('translation.general.task.process-complete'));
        }

        return redirect()->route('task.index', ['xmlProcessId' => $xmlProcessId, 'xmlInstanceId' => $instanceId]);
    }

    public function finishAndNextTask(Request $request, $taskId, $xmlProcessId, $processName, $instanceId)
    {
        $process = Process::whereXmlProcessId($xmlProcessId)->first();
        $task = Task::whereXmlTaskId($taskId)->first();

        newAnalytics($request, 'Finish And Next Task', 'system', Session::get('policyName'), $process->xml_process_name, $task->xml_task_name);
        $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task/" . $taskId . "/complete";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $completeResult = json_decode($result, true);

        AllTask::whereXmlTaskName($task->xml_task_name)->whereInstanceId($task->instance_id)->first()->update(["status" => 2, "phase" => $task->phase, "finished_at" => Carbon::now()]);
        Task::whereXmlTaskId($taskId)->delete();
        Widget::where('task_name', $task->xml_task_name)->delete();
        sleep(2);

        $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $tasksResultRows = json_decode($result, true);
        if (!is_null($tasksResultRows)) {
            foreach ($tasksResultRows as $row) {
                if ($row['processInstanceId'] == $instanceId) {
                    $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task/" . $row['id'] . "/variables";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $jsonDecodeSuccess = json_decode($result, true);

                    if (isset($jsonDecodeSuccess['end'])) {
                        $last_task = 1;
                    } else {
                        $last_task = 0;
                    }

                    if (isset($jsonDecodeSuccess['kafka'])) {
                        $kafka = 1;
                    } else {
                        $kafka = 0;
                    }

                    if (isset($jsonDecodeSuccess['maps'])) {
                        $maps = 1;
                    } else {
                        $maps = 0;
                    }

                    if (isset($jsonDecodeSuccess['link1'])) {
                        $link1 = 1;
                    } else {
                        $link1 = 0;
                    }

                    if (isset($jsonDecodeSuccess['link2'])) {
                        $link2 = 1;
                    } else {
                        $link2 = 0;
                    }

                    if (isset($jsonDecodeSuccess['link3'])) {
                        $link3 = 1;
                    } else {
                        $link3 = 0;
                    }

                    $task = new Task();
                    $task->user_id = Auth::user()->id;
                    $task->assignee = $row['assignee'];
                    $task->xml_definition_id = $row['processDefinitionId'];
                    $task->xml_task_name = $row['name'];
                    $task->xml_task_id = $row['id'];
                    $task->xml_process_id = $xmlProcessId;
                    $task->process_name = $processName;
                    $task->instance_id = $row['processInstanceId'];
                    $task->phase = $jsonDecodeSuccess['phase']['value'];
                    $task->description = $jsonDecodeSuccess['description']['value'];
                    $task->last_task = $last_task;
                    $task->kafka = $kafka;
                    $task->maps = $maps;
                    $task->link1 = $link1;
                    $task->link2 = $link2;
                    $task->link3 = $link3;
                    $task->save();
                    AllTask::whereXmlTaskName($task->xml_task_name)->whereInstanceId($task->instance_id)->first()->update(["started_at" => Carbon::now(), "status" => 1, "phase" => $task->phase]);
                }
            }

            $url = "http://". $this->getSetting()->camunda_ip .":" . $this->getSetting()->camunda_port . "/engine-rest/history/process-instance/". $instanceId;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            $completeResult = json_decode($result, true);

            if ($completeResult['state'] == "COMPLETED"){
                Process::whereXmlInstanceId($instanceId)->first()->update(['completed' => 1, 'completed_at' => Carbon::now()]);
                session_success( trans('translation.general.task.process-complete'));
                return redirect()->route('task.index', ['xmlProcessId' => $xmlProcessId, 'xmlInstanceId' => $instanceId]);
            }
            return redirect()->route('task.show', ['xmlTaskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'xmlTaskName' => $task->xml_task_name]);
        } else {
            session_success( trans('translation.general.task.process-complete'));
            return redirect()->route('task.index', ['xmlProcessId' => $xmlProcessId, 'xmlInstanceId' => $instanceId]);
        }
        //return redirect()->route('task.show',['xmlTaskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'xmlTaskName' => $task->xml_task_name]);
    }

    public function submitFormAndNextTask(Request $request, $taskId, $xmlProcessId, $processName, $instanceId)
    {

        $formElements = $request->all();
        foreach ($formElements as $key => $value) {
            $variables[$key]['value'] = $value;
        }

        $options = [
            'variables' => $variables,
        ];

        $process = Process::whereXmlProcessId($xmlProcessId)->first();
        $task = Task::whereXmlTaskId($taskId)->first();
        newAnalytics($request, 'Submit Form Next Task', 'system', Session::get('policyName'), $process->xml_process_name, $task->xml_task_name);
        $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task/" . $taskId . "/submit-form";

        $ch = curl_init($url);
        $payload = json_encode($options);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $completeResult = json_decode($result, true);

        //dd($result);

        AllTask::whereXmlTaskName($task->xml_task_name)->whereInstanceId($task->instance_id)->first()->update(["status" => 2, "phase" => $task->phase, "finished_at" => Carbon::now()]);
        Task::whereXmlTaskId($taskId)->delete();
        Widget::where('task_name', $task->xml_task_name)->delete();
        sleep(2);

        $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $tasksResultRows = json_decode($result, true);
        if (!is_null($tasksResultRows)) {
            foreach ($tasksResultRows as $row) {
                if ($row['processInstanceId'] == $instanceId) {
                    $url = "http://" . $this->getSetting()->camunda_ip . ":" . $this->getSetting()->camunda_port . "/engine-rest/task/" . $row['id'] . "/variables";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $jsonDecodeSuccess = json_decode($result, true);

                    if (isset($jsonDecodeSuccess['end'])) {
                        $last_task = 1;
                    } else {
                        $last_task = 0;
                    }

                    if (isset($jsonDecodeSuccess['kafka'])) {
                        $kafka = 1;
                    } else {
                        $kafka = 0;
                    }

                    if (isset($jsonDecodeSuccess['maps'])) {
                        $maps = 1;
                    } else {
                        $maps = 0;
                    }

                    if (isset($jsonDecodeSuccess['link1'])) {
                        $link1 = 1;
                    } else {
                        $link1 = 0;
                    }

                    if (isset($jsonDecodeSuccess['link2'])) {
                        $link2 = 1;
                    } else {
                        $link2 = 0;
                    }

                    if (isset($jsonDecodeSuccess['link3'])) {
                        $link3 = 1;
                    } else {
                        $link3 = 0;
                    }

                    $task = new Task();
                    $task->user_id = Auth::user()->id;
                    $task->assignee = $row['assignee'];
                    $task->xml_definition_id = $row['processDefinitionId'];
                    $task->xml_task_name = $row['name'];
                    $task->xml_task_id = $row['id'];
                    $task->xml_process_id = $xmlProcessId;
                    $task->process_name = $processName;
                    $task->instance_id = $row['processInstanceId'];
                    $task->phase = $jsonDecodeSuccess['phase']['value'];
                    $task->description = $jsonDecodeSuccess['description']['value'];
                    $task->last_task = $last_task;
                    $task->kafka = $kafka;
                    $task->maps = $maps;
                    $task->link1 = $link1;
                    $task->link2 = $link2;
                    $task->link3 = $link3;
                    $task->save();
                    AllTask::whereXmlTaskName($task->xml_task_name)->whereInstanceId($task->instance_id)->first()->update(["started_at" => Carbon::now(), "status" => 1, "phase" => $task->phase]);
                }
            }
            $url = "http://". $this->getSetting()->camunda_ip .":" . $this->getSetting()->camunda_port . "/engine-rest/history/process-instance/". $instanceId;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            $completeResult = json_decode($result, true);

            if ($completeResult['state'] == "COMPLETED"){
                Process::whereXmlInstanceId($instanceId)->first()->update(['completed' => 1, 'completed_at' => Carbon::now()]);
                session_success( trans('translation.general.task.process-complete'));
                return redirect()->route('task.index', ['xmlProcessId' => $xmlProcessId, 'xmlInstanceId' => $instanceId]);
            }
            return redirect()->route('task.show', ['xmlTaskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'xmlTaskName' => $task->xml_task_name]);
        } else {
            session_success( trans('translation.general.task.process-complete'));
            return redirect()->route('task.index', ['xmlProcessId' => $xmlProcessId, 'xmlInstanceId' => $instanceId]);
        }
        //return redirect()->route('task.show',['xmlTaskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'xmlTaskName' => $task->xml_task_name]);
    }

    public function completedTaskShow(Request $request, $xmlTaskId, $xmlProcessId, $xmlInstanceId, $xmlTaskName)
    {
        $task = AllTask::whereXmlTaskName($xmlTaskName)->first();
        $allTasks = AllTask::whereInstanceId($task->instance_id)->orderBy('xml_task_name', 'asc')->get();
        $process = Process::whereXmlProcessId($xmlProcessId)->first();
        $widget = NewWidget::whereXmlProcessId($xmlProcessId)->whereTaskName($task->xml_task_name)->first();
        $completedTaskShowPage = true;
        newAnalytics($request, 'Completed Task Detail', 'page_transition', Session::get('policyName'), $process->xml_process_name, $task->xml_task_name);

        $taskComments = TaskComment::whereInstanceId($xmlInstanceId)->whereXmlProcessId($xmlProcessId)->get();
        $taskDateFilter = ProcessDesignDateFilter::whereTaskName($xmlTaskName)->whereXmlProcessId($xmlProcessId)->first();

//        dd($task);
        return view('admin.task.show', compact('widget', 'allTasks','task', 'xmlProcessId', 'widget', 'completedTaskShowPage', 'process', 'taskComments', 'taskDateFilter'))->with('page', $this->page);
    }

    public function addComment(Request $request)
    {
        $taskComment = new TaskComment();
        $taskComment->user_id = Auth::id();
        $taskComment->xml_task_id = $request->xmlTaskId;
        $taskComment->xml_process_id = $request->xmlProcessId;
        $taskComment->instance_id = $request->instanceId;
        $taskComment->xml_task_name = $request->xmlTaskName;
        $taskComment->comment = $request->comment;
        $taskComment->save();

        $taskComments = TaskComment::whereInstanceId($request->instanceId)->whereXmlProcessId($request->xmlProcessId)->get();

        return view('admin.task.comments', compact('taskComments'));
    }
}
