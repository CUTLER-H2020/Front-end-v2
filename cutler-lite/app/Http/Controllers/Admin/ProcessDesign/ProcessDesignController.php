<?php

namespace App\Http\Controllers\Admin\ProcessDesign;

use App\Http\Controllers\Controller;
use App\Models\Analytics;
use App\Models\KibanaWidgets;
use App\Models\NewWidget;
use App\Models\Policy;
use App\Models\Process;
use App\Models\ProcessDesignDateFilter;
use App\Models\ProcessImage;
use App\Models\Setting;
use App\Models\Task;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Class ProcessDesignController
 * @package App\Http\Controllers\Admin\ProcessDesign
 */
class ProcessDesignController extends Controller
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
        $this->camundaSource = $this->settings->camunda_ip . ':' . $this->settings->camunda_port;
        $this->page['title'] = 'Process Design';
        $this->page['sub_title'] = '';
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $processId = $request->get('processId', null);
        $processListContent = $this->client
            ->request('GET', $this->camundaSource . '/engine-rest/process-definition')
            ->getBody()
            ->getContents();
        $processList = collect(json_decode($processListContent, true))->pluck('name', 'id')->toArray();
        $processListWithId = collect(json_decode($processListContent, true))->toArray();

        $processList = array_merge([trans('translation.general.select-process')], $processList);
        $policyList = Policy::orderBy('id', 'DESC')->pluck('name', 'id');
        $policyList = collect([trans('translation.general.select-policy')] + $policyList->all());

        return view(
            'admin.process-design2.index',
            compact('processList', 'processListWithId', 'processId', 'policyList')
        )->with('page', $this->page);
    }

    /**
     * @param Request $request
     * @param string $taskKey
     * @return Factory|View
     */
    public function detail(Request $request, string $taskKey)
    {
        $this->page['title'] = 'Widget Select For Process Design';
        $this->page['sub_title'] = $taskKey;
        $processId = $request->get('processId', null);
        $processName = $request->get('processName', null);
        $taskName = $request->get('taskName', null);
        $processKey = $request->get('processKey', null);
        $widgetsContent = $this->client
            ->request('GET', $this->settings->kibana_widget_url)
            ->getBody()
            ->getContents();
        $widgets = json_decode($widgetsContent, true);
        $cutlerWidgets = NewWidget::get();

        $widgetTmp = [];
        foreach ($widgets as $widget){
            array_push($widgetTmp, $widget['id']);
        }

        foreach ($cutlerWidgets as $cutlerWidget){
            if (!in_array($cutlerWidget->widget_id, $widgetTmp)){
                NewWidget::whereWidgetId($cutlerWidget->widget_id)->delete();
            }
        }

        $savedWidgets = NewWidget::query()
            ->select(['widget_name', 'widget_title', 'widget_type', 'widget_id', 'task_name'])
            ->where(['xml_process_id' => $processId])
            ->where(['task_name' => $taskName])
            ->get();
        $widgetObjects = [];

        foreach ($savedWidgets as $key => $widget) {
            $widgetObjects[$key]['id'] = $widget['widget_id'];
            $widgetObjects[$key]['json'] = json_encode([
                'name' => $widget['widget_name'],
                'type' => $widget['widget_type'],
                'title' => $widget['widget_title'],
                'id' => $widget['widget_id'],
            ]);
        }

        $taskDateFilter = ProcessDesignDateFilter::whereTaskName($taskName)->whereXmlProcessId($processId)->first();

        return view(
            'admin.process-design2.detail',
            compact('widgets', 'widgetObjects', 'processId', 'processName', 'taskName', 'processKey', 'taskKey', 'taskDateFilter')
        )->with('page', $this->page);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View
     */
    public function getTasks(Request $request)
    {
        $processKey = $request->get('process_key', null);
        $processId = $request->get('process_id', null);
        $processImage = ProcessImage::where('process_id', $processId)->first();
        $tasks = $this->getTasksByProcessKey($processKey);
        $tasksReturn = [];

        $widgets = NewWidget::query()->where(['xml_process_key' => $processKey])->get()->groupBy('task_name');
        $widget = NewWidget::query()->where(['xml_process_key' => $processKey])->get();
        $widgetCounts = collect();
        $widgetCountsByName = array();

        foreach ($tasks[2] as $key => $name) {

            $name = trim($name);

            foreach ($widgets as $taskName => $widget) {
               $widgetCounts->push(['name' => trim($taskName), 'count' => count($widget)]);
               $widgetCountsByName[md5($taskName)] = count($widget);
            }

            $tasksReturn[$key]['detail_url'] = route('process-design2.detail', $tasks[1][$key]);
            $tasksReturn[$key]['name'] = $name;
            $tasksReturn[$key]['assignee'] = $tasks[3][$key];
            $tasksReturn[$key]['cusergrouptemp'] = $tasks[0][$key];
            $tasksReturn[$key]['candidateUsers'] = '';
            $tasksReturn[$key]['candidateGroups'] = '';

            if (strpos($tasksReturn[$key]['assignee'], '"')) {
                $temp = explode('"', $tasksReturn[$key]['assignee']);
                $tasksReturn[$key]['assignee'] = $temp[0];
            }

            if (strpos($tasksReturn[$key]['cusergrouptemp'], 'camunda:candidateUsers')) {
                $temp = explode('camunda:candidateUsers="', $tasksReturn[$key]['cusergrouptemp']);
                $temp = explode('"', $temp[1]);
                $tasksReturn[$key]['candidateUsers'] = $temp[0];
            }

            if (strpos($tasksReturn[$key]['cusergrouptemp'], 'camunda:candidateGroups')) {
                $temp = explode('camunda:candidateGroups="', $tasksReturn[$key]['cusergrouptemp']);
                $temp = explode('"', $temp[1]);
                $tasksReturn[$key]['candidateGroups'] = $temp[0];
            }

            if(array_key_exists(md5($name), $widgetCountsByName)){
                $currentWidgetCount = $widgetCountsByName[md5($name)];
            } else {
                $currentWidgetCount = 0;
            }

            $tasksReturn[$key]['description'] = $tasks[7][$key];
            //$tasksReturn[$key]['widgets_count'] = $currentWidget ? $currentWidget['count'] : 0;
            $tasksReturn[$key]['widgets_count'] = $currentWidgetCount;
            $tasksReturn[$key]['processKey'] = $processKey;
            $tasksReturn[$key]['filteredProcessName'] = $request->filteredProcessName;
            $tasksReturn[$key]['filteredProcessId'] = $request->filteredProcessId;
            $tasksReturn[$key]['widgetPreview'] = NewWidget::whereTaskName($name)->whereXmlProcessId($processId)->first();
        }

        return view('admin.process-design2.tasks', compact('tasksReturn', 'processId', 'processImage'));
    }

    public function processImageUpload(Request $request)
    {

        if (!File::exists(public_path("uploads/process/"))) {
            File::makeDirectory(public_path("uploads/process/"), '0755', true);
        }

        $validateImage = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        if ($validateImage) {
            $processImage = ProcessImage::where('process_id', $request->process_id)->first();
            if ($processImage) {
                $data['image'] = date("Ymd-His") . '-' . rand(1111, 9999) . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/process'), $data['image']);

                @unlink(public_path('uploads/process/' . $processImage->image));
                $processImage->image = $data['image'];

                $status = $processImage->save();

            } else {
                $data['process_id'] = $request->process_id;
                $data['image'] = date("Ymd-His") . '-' . rand(1111, 9999) . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/process'), $data['image']);
                $status = ProcessImage::create($data);
            }

            if ($status) {
                return response()->json(['success' => 'done']);
            } else {
                return response()->json(['error' => 'error']);
            }
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function addWidgetToTask(Request $request)
    {
        $data = $request->all();
        $processFiltered = $this->getProcessByProcessId($data['process_id']);
        $userId = Auth::user()->id;

        $tasks = $this->getTasksByProcessKey($data['process_key']);
        $taskArrayKey = array_keys(array_filter($tasks[1], function ($value, $key) use ($data) {
            return $value === $data['task_key'];
        }, ARRAY_FILTER_USE_BOTH))[0];

        $body = [];

        $body = array_merge($body, ['version' => '7.1.1']);
        $body = array_merge($body, ['objects' => []]);
        $dashboardId = Str::substr(md5((string)Str::uuid() . time()), 0, 20);
        $dashboardTitleSuffix = Str::substr(md5(time()), 0, 5);
        $object = [
            'id' => $dashboardId,
            'type' => 'dashboard',
            'attributes' => [
                'title' => 'Dashboard-' . $dashboardTitleSuffix,
                'hits' => 0,
                'description' => 'Dashboard',
                'panelsJSON' => '',
                'optionsJSON' => '{"hidePanelTitles":false,"useMargins":true}',
                'version' => 1,
                'timeRestore' => true,
                'timeTo' => 'now',
                'timeFrom' => 'now-7d',
                'refreshInterval' => ['pause' => false, 'value' => 900000],
                'kibanaSavedObjectMeta' => [
                    'searchSourceJSON' => '{"query":{"language":"kuery","query":""},"filter":[]}',
                ],
            ],
            'migrationVersion' => ['dashboard' => '7.0.0'],
            'references' => [],
        ];
        array_push($body['objects'], $object);

        $references = [];
        $panels = [];

        NewWidget::query()
            ->where(['xml_process_name' => $data['process_name']])
            ->where(['task_name' => $data['task_name']])
            ->delete();

        $sortKey = 0;

        if ($request->has('widget')){
            $content = json_decode(rawurldecode($request->widget));
            NewWidget::query()->create(
                [
                    'user_id' => $userId,
                    'xml_process_id' => $processFiltered['id'],
                    'xml_process_name' => $data['process_name'],
                    'xml_process_key' => $data['process_key'],
                    'task_name' => $data['task_name'],
                    'task_phase' => $tasks[5][$taskArrayKey],
                    'widget_id' => $content->id,
                    'widget_type' => $content->type,
                    'widget_title' => $content->title,
                    'widget_name' => $content->name,
                    'dashboard_id' => $content->id,
                    'dashboard_title' => 'Dashboard-' . $dashboardTitleSuffix,
                ]
            );
        } else {
            foreach ($data['widgets'] as $key => $widget) {
                $content = json_decode(rawurldecode($widget));
                NewWidget::query()->create(
                    [
                        'user_id' => $userId,
                        'xml_process_id' => $processFiltered['id'],
                        'xml_process_name' => $data['process_name'],
                        'xml_process_key' => $data['process_key'],
                        'task_name' => $data['task_name'],
                        'task_phase' => $tasks[5][$taskArrayKey],
                        'widget_id' => $content->id,
                        'widget_type' => $content->type,
                        'widget_title' => $content->title,
                        'widget_name' => $content->name,
                        'dashboard_id' => $dashboardId,
                        'dashboard_title' => 'Dashboard-' . $dashboardTitleSuffix,
                    ]
                );

                $fixedWidth = '24';

                $sortKey = $key % 2 === 0 ? 0 : ++$sortKey;

                $panels[] = '{"embeddableConfig":{},' .
                    '"gridData":{"x":' . ($sortKey * $fixedWidth) . ',"y":0,"w":24,"h":10,"i":"' . (2 + $key) . '"},' .
                    '"panelIndex":"' . (2 + $key) . '","version":"7.1.1","panelRefName":"panel_' . $key . '"}';

                $widget = [
                    'name' => 'panel_' . $key,
                    'type' => 'visualization',
                    'id' => $content->id,
                ];

                $references[] = $widget;
                sleep(0.1);
            }

            $body['objects'][0]['attributes']['panelsJSON'] .= '[' . implode(',', $panels) . ']';
            $body['objects'][0]['references'] = $references;

            $importKibana = $this->client->request(
                'POST',
                $this->settings->kibana_ip . ':' . $this->settings->kibana_port . '/api/kibana/dashboards/import',
                [
                    'auth' => [$this->settings->kibana_username, $this->settings->kibana_pass],
                    'headers' => [
                        'kbn-xsrf' => true,
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36',
                        'Content-Type' => 'application/json',
                    ],
                    'body' => json_encode($body),
                    'verify' => false,
                ]
            );
            $importKibanaStatus = $importKibana->getStatusCode();
            if ($importKibanaStatus != 200) {
                NewWidget::whereXmlProcessId($data['process_id'])->delete();
                session_error(trans('translation.general.kibana-error'));
                return redirect()->route('process-design2.index', ['processId' => $data['process_id']]);
            }
        }

        if(isset($data['start_date']) && isset($data['end_date'])){
            $lastSelection = null;

            ProcessDesignDateFilter::where('xml_process_id', $processFiltered['id'])->where('xml_process_name', $data['process_name'])->where('xml_process_key', $data['process_key'])->whereTaskName($data['task_name'])->delete();

            ProcessDesignDateFilter::create([
                'xml_process_id' => $processFiltered['id'],
                'xml_process_name' => $data['process_name'],
                'xml_process_key' => $data['process_key'],
                'task_name' => $data['task_name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'last_selection' => $lastSelection,
            ]);
        } else {
            ProcessDesignDateFilter::where('xml_process_id', $processFiltered['id'])->where('xml_process_name', $data['process_name'])->where('xml_process_key', $data['process_key'])->whereTaskName($data['task_name'])->delete();

            ProcessDesignDateFilter::create([
                'xml_process_id' => $processFiltered['id'],
                'xml_process_name' => $data['process_name'],
                'xml_process_key' => $data['process_key'],
                'task_name' => $data['task_name'],
                'start_date' => null,
                'end_date' => null,
                'last_selection' => $data['last_selection'] ?? null,
            ]);
        }

        session_success(trans('translation.general.widget-success'));

        return redirect()->route('process-design2.index', ['processId' => $data['process_id']]);
    }

    /**
     * @param string $processId
     * @return mixed
     */
    private function getProcessByProcessId($processId)
    {
        $processListContent = $this->client
            ->request('GET', $this->camundaSource . '/engine-rest/process-definition')
            ->getBody()
            ->getContents();
        $processList = collect(json_decode($processListContent, true));

        return $processList->filter(function ($value) use ($processId) {
            return $value['id'] === $processId;
        })->first();
    }

    /**
     * @param string $processKey
     * @return array
     */
    private function getTasksByProcessKey($processKey)
    {
        $tasksContent = $this->client
            ->request('GET', $this->camundaSource . '/engine-rest/process-definition/key/' . $processKey . '/xml');
        $taskXml = json_decode($tasksContent->getBody()->getContents(), true)['bpmn20Xml'];

        preg_match_all(
            '|<bpmn:userTask id="(.*?)" name="(.*?)" camunda:assignee="(.*?)">(.*?)<camunda:inputParameter name="phase">(.*?)</camunda:inputParameter>(.*?)<camunda:inputParameter name="description">(.*?)</camunda:inputParameter>(.*?)</bpmn:userTask>|is',
            $taskXml,
            $tasks
        );

        return $tasks;
    }

    /**
     * @param array $body
     * @return string
     */
    private function importDashboardToKibana($body)
    {
        $importKibana = $this->client->request(
            'POST',
            $this->settings->kibana_ip . ':' . $this->settings->kibana_port . '/api/kibana/dashboards/import',
            [
                'auth' => [$this->settings->kibana_username, $this->settings->kibana_pass],
                'headers' => [
                    'kbn-xsrf' => true,
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36',
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($body),
                'verify' => false,
            ]
        );
        $importKibanaContent = $importKibana->getBody()->getContents();
        $importKibanaStatus = $importKibana->getStatusCode();
        return $importKibanaContent;
    }

    public function assignProcessToPolicy(Request $request)
    {
        $beforeAssignToPolicies = Process::whereXmlProcessId($request->process_id)->get();
        if ($beforeAssignToPolicies->count() > 0) {
            foreach ($beforeAssignToPolicies as $beforeAssignToPolicy) {
                $beforeAssignToPolicy->xml_process_id = $request->process_id;
                $beforeAssignToPolicy->xml_process_name = $request->process_name;
                $beforeAssignToPolicy->policy_id = $request->policy_id;
                $beforeAssignToPolicy->policy_name = $request->policy_name;
                $beforeAssignToPolicy->save();
            }
            return 1;
        } else {
            $process = new Process();
            $process->created_user_id = Auth::user()->id;
            $process->xml_process_id = $request->process_id;
            $process->xml_process_name = $request->process_name;
            $process->policy_id = $request->policy_id;
            $process->policy_name = $request->policy_name;
            $process->save();
            return 1;
        }
    }

    public function getSelectedPolicy(Request $request)
    {
        $process = Process::whereXmlProcessId($request->processId)->first();
        if ($process) {
            return $process->policy_id;
        } else {
            return 0;
        }
    }

    public function dashboardPreviewModel(Request $request)
    {
        $taskDateFilter = ProcessDesignDateFilter::whereTaskName($request->task_name)->whereXmlProcessId($request->process_id)->first();
        if ($taskDateFilter){
            if (is_null($taskDateFilter->last_selection)) {
                if($taskDateFilter->start_date!=''){
                    $time = "from:'" . $taskDateFilter->start_date . "',to:'" . $taskDateFilter->end_date . "'";
                    $iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!t,value:0)%2Ctime%3A(". $time ."))&_a=(description:'',filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!f,viewMode:view)";
                } else {
                    $iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id;
                }
            }else{
                switch ($taskDateFilter->last_selection) {
                    case "7d":
                        $iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!t,value:0)%2Ctime%3A(from%3Anow-7d%2Cto%3Anow))&_a=(description:'',filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!f,viewMode:view)";
                        //$iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-7d%2Cto%3Anow))";
                        break;
                    case "1M":
                        $iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!t,value:0)%2Ctime%3A(from%3Anow-1M%2Cto%3Anow))&_a=(description:'',filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!f,viewMode:view)";
                        //$iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-1M%2Cto%3Anow))";
                        break;
                    case "1y":
                        $iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!t,value:0)%2Ctime%3A(from%3Anow-1y%2Cto%3Anow))&_a=(description:'',filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!f,viewMode:view)";
                        //$iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-1y%2Cto%3Anow))";
                        break;
                    case "3y":
                        $iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!t,value:0)%2Ctime%3A(from%3Anow-3y%2Cto%3Anow))&_a=(description:'',filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!f,viewMode:view)";
                        //$iframe = $this->settings->kibana_preview_url."/app/kibana#/dashboard/".$request->dashboard_id."?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-3y%2Cto%3Anow))";
                        break;
                }
            }
        }
        return view('admin.process-design2.dashboard-preview-modal', compact('request', 'taskDateFilter', 'iframe'));
    }
}
