<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllTask;
use App\Models\Policy;
use App\Models\Process;
use App\Models\Widget;
use App\User;
use Illuminate\Http\Request;

class ProcessDesignController extends Controller
{
    public function __construct()
    {
        $this->page['title'] = 'Process Design';
        $this->page['sub_title'] = '';
    }

    public function index(Request $request)
    {
        $policyList = Policy::pluck('name','id');
        $policyList = collect(['' => 'Select Policy'] + $policyList->all());
        $processList = Process::pluck('xml_process_name','xml_process_id');
        $processList = collect(['' => 'Select Process'] + $processList->all());
        return  view('admin.process-design.index',compact('policyList','processList'))->with('page', $this->page);
    }

    public function getTasks(Request $request)
    {
        $tasks = AllTask::whereProcessName($request->process_name)->get();
        return view('admin.process-design.task-select-list', compact('tasks'));
    }

    public function getSelectedWidgets(Request $request)
    {
        $widgets = Widget::wherePolicyId($request->selectedPolicyID)->whereProcessId($request->selectedProcessID)->whereTaskId($request->selectedTaskID)->whereTaskName($request->selectedTask)->get();
        return view('admin.process-design.selected-widgets', compact('widgets'));
    }

    public function getUser(Request $request)
    {
        $policy = Policy::where('id', $request->selectedPolicyID)->first();
        $policyUser = User::find($policy->user_id);
        return view('admin.process-design.user-details', compact('policyUser'));
    }
}

