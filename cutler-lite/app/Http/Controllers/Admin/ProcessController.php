<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllTask;
use App\Models\NewWidget;
use App\Models\Policy;
use App\Models\Process;
use App\Models\Setting;
use App\Models\Task;
use App\Models\Widget;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProcessController extends Controller
{
    private $client;
    private $settings;
    private $camundaSource;

    /**
     * ProcessDesignController constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->settings = Setting::find(1);
        $this->camundaSource = $this->settings->camunda_ip.':'.$this->settings->camunda_port;
        $this->page['title'] = 'Process';
        $this->page['sub_title'] = '';
    }

    public function index(Request $request, $policyId)
    {
        $startedProcesses = Process::wherePolicyId($policyId)->whereStarted(1)->whereCompleted(0)->get();
        $completedProcesses = Process::wherePolicyId($policyId)->whereStarted(1)->whereCompleted(1)->get();
        return view('admin.process.index', compact('startedProcesses', 'completedProcesses', 'policyId'))->with('page', $this->page);
    }

    public function saveWidget(Request $request)
    {
        $widget = new Widget();
        $widget->policy_name = $request->policy_name;
        $widget->policy_id = $request->policy_id;
        $widget->process_name = $request->process_name;
        $widget->process_id = $request->process_id;
        $widget->task_name = $request->task_name;
        $widget->task_id = $request->task_id;
        $widget->widget_name = $request->widget_name;
        $widget->widget_title = $request->widget_title;
        $widget->widget_type = $request->widget_type;
        $widget->widget_id = $request->widget_id;
        $widget->save();
    }

    public function startNewProcess(Request $request)
    {
        $url = "http://". $this->getSetting()->camunda_ip .":". $this->getSetting()->camunda_port ."/engine-rest/process-definition/". $request->processId . "/start";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $result=curl_exec($ch);
        curl_close($ch);
        $definitionResult = json_decode($result, true);

        $process = Process::whereXmlProcessId($request->processId)->orderBy('created_at', 'DESC')->first();
        $processCount = Process::whereXmlProcessId($request->processId)->where('started', 1)->count();
        if ($processCount < 1){
            $process->xml_instance_id = $definitionResult['id'];
            $process->xml_definition_id = $definitionResult['definitionId'];
            $process->started = 1;
            $process->started_user_id = Auth::id();
            $process->started_at = Carbon::now();
            $process->save();
            $process = Process::whereXmlProcessId($request->processId)->orderBy('created_at', 'DESC')->first();
        }else{
            $newProcess = new Process();
            $newProcess->created_user_id = $process->created_user_id;
            $newProcess->xml_process_id = $process->xml_process_id;
            $newProcess->xml_process_name = $process->xml_process_name;
            $newProcess->xml_instance_id = $definitionResult['id'];
            $newProcess->xml_definition_id = $definitionResult['definitionId'];
            $newProcess->policy_id = $process->policy_id;
            $newProcess->policy_name = $process->policy_name;
            $newProcess->started = 1;
            $newProcess->started_user_id = Auth::id();
            $newProcess->started_at = Carbon::now();
            $newProcess->save();
            $process = Process::whereXmlProcessId($request->processId)->orderBy('created_at', 'DESC')->skip(1)->first();
            $process->started = 1;
            $process->save();
            $process = Process::whereXmlProcessId($request->processId)->orderBy('created_at', 'DESC')->first();
        }

        $url = "http://". $this->getSetting()->camunda_ip .":". $this->getSetting()->camunda_port ."/engine-rest/task";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result=curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        foreach ($result as $row){
            if ($row['processInstanceId'] == $process->xml_instance_id){
                $url = "http://". $this->getSetting()->camunda_ip .":". $this->getSetting()->camunda_port ."/engine-rest/task/". $row['id']."/variables";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL,$url);
                $result=curl_exec($ch);
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
                $task->xml_definition_id = $definitionResult['definitionId'];
                $task->xml_task_name = $row['name'];
                $task->xml_task_id = $row['id'];
                $task->xml_process_id = $request->processId;
                $task->process_name = $request->processName;
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
            }
        }

        $data['process'] = $process;
        $data['task'] = $task;
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function writeAllTasksToDatabase(Request $request)
    {
        if ($request->xml_task_name == $request->response['task']['xml_task_name']){
            $allTask = new AllTask();
            $allTask->user_id = Auth::user()->id;
            $allTask->assignee = $request->assignee;
            $allTask->xml_task_name = $request->xml_task_name;
            $allTask->xml_task_id = $request->xml_task_id;
            $allTask->definition_id = $request->definitionId;
            $allTask->instance_id = $request->instanceId;
            $allTask->process_name = $request->process_name;
            $allTask->status = 1;
            $allTask->phase = $request->phase;
            $allTask->description = $request->description;
            $allTask->started_at = Carbon::now();
            $allTask->save();
        }else{
            $allTask = new AllTask();
            $allTask->user_id = Auth::user()->id;
            $allTask->assignee = $request->assignee;
            $allTask->xml_task_name = $request->xml_task_name;
            $allTask->xml_task_id = $request->xml_task_id;
            $allTask->definition_id = $request->definitionId;
            $allTask->instance_id = $request->instanceId;
            $allTask->process_name = $request->process_name;
            $allTask->phase = $request->phase;
            $allTask->description = $request->description;
            $allTask->save();
        }


        return 1;
    }

    public function deleteWidget(Request $request)
    {
        Widget::find($request->widgetId)->delete();
        return 1;
    }

    public function startNewProcessModal(Request $request)
    {
        $processListContent = $this->client
            ->request('GET', $this->camundaSource . '/engine-rest/process-definition')
            ->getBody()
            ->getContents();
        $processList = json_decode($processListContent, true);

        $newProcessList = [];
        foreach ($processList as $process){

//            $processAssigmentToPolicy = Process::whereXmlProcessId($process['id'])->wherePolicyId($request->policyId)->whereStarted(0)->first();
            $processAssigmentToPolicy = Process::whereXmlProcessId($process['id'])->wherePolicyId($request->policyId)->first();
            if ($processAssigmentToPolicy){
                $tasksContent = $this->client
                    ->request('GET', $this->camundaSource . '/engine-rest/process-definition/key/' . $process['key'] . '/xml');
                $taskXml = json_decode($tasksContent->getBody()->getContents(), true)['bpmn20Xml'];

                preg_match_all(
                    '|<bpmn:userTask id="(.*?)" name="(.*?)" camunda:assignee="(.*?)">(.*?)<camunda:inputParameter name="phase">(.*?)</camunda:inputParameter>(.*?)</bpmn:userTask>|is',
                    $taskXml,
                    $tasks
                );

                $widgetCounts = [];

                foreach ($tasks[2] as $key => $name){
                    $widgetCount = NewWidget::whereTaskName($name)->whereXmlProcessKey($process['key'])->count();
                    array_push($widgetCounts, $widgetCount);
                }

                if (in_array(0, $widgetCounts)){
                    $disabledButton = true;
                }else{
                    $disabledButton = false;
                }

                $processWithWidget = collect($process + ['disabledButton' => $disabledButton]);
                array_push($newProcessList, $processWithWidget);
            }

        }

        return view('admin.policies.start-new-process-modal')->with('newProcessList', $newProcessList);
    }

    public function startNewProcessByPass(Request $request){
        $processId = $request->processId;

        $tempData = $this->client
            ->request('GET', $this->camundaSource . '/engine-rest/process-definition/'.$processId.'/xml')
            ->getBody()
            ->getContents();
        $tempData = json_decode($tempData, true);

        return response()->json($tempData);
    }

    public function getUserProcess(Request $request)
    {
        $startedProcesses = Process::wherePolicyId($request->policy_id)->whereStartedUserId(Auth::id())->whereStarted(1)->whereCompleted(0)->get();
        $completedProcesses = Process::wherePolicyId($request->policy_id)->whereStartedUserId(Auth::id())->whereStarted(1)->whereCompleted(1)->get();
        return view('admin.process.user-processes', compact('startedProcesses', 'completedProcesses'));
    }

    public function getAllProcess(Request $request)
    {
        $startedProcesses = Process::wherePolicyId($request->policy_id)->whereStarted(1)->whereCompleted(0)->get();
        $completedProcesses = Process::wherePolicyId($request->policy_id)->whereStarted(1)->whereCompleted(1)->get();
        return view('admin.process.user-processes', compact('startedProcesses', 'completedProcesses'));
    }

    public function deleteProcess($instanceId)
    {
        $process = Process::whereXmlInstanceId($instanceId)->first();
        Process::whereXmlInstanceId($instanceId)->delete();
        Task::whereInstanceId($instanceId)->delete();
        AllTask::whereInstanceId($instanceId)->delete();
        $tempData = $this->client
            ->request('DELETE', $this->camundaSource . '/engine-rest/process-instance/'.$instanceId)
            ->getBody()
            ->getContents();
        $tempData = json_decode($tempData, true);

        $process = Process::whereXmlProcessId($process->xml_process_id)->first();
        if ($process){
            session_success("Process deleted");
            return redirect()->route('process.index', ['policyId' => $process->policy_id]);
        }else{
            session_success("Process deleted, redirect policies page.");
            return redirect()->route('policy.index');
        }
    }
}
