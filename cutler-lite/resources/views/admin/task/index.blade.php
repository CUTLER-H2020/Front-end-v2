@extends('admin.parent')

@section('title', trans('translation.general.tasks.tasks'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'task.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>{{ trans('translation.general.tasks.tasks') }}</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD-->
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="{{ route('dashboard') }}">{{ trans('translation.admin.dashboard') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span class="active">{{ trans('translation.general.tasks.tasks') }}</span>
                </li>
            </ul>

            <hr>
            <div class="row">

            <div class="col-md-6">
            <h4><span
                    style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.policy-name') }}</span>
                : {{ $process->policy_name }}</h4>
            <h4><span
                    style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.process-name') }}</span>
                : {{ $process->xml_process_name }}</h4>
            <h4><span style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task.start-date') }}</span>
                : {{ $allTasks->first()->started_at ?? 'Not started' }}</h4>
            <h4><span style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task.end-date') }}</span>
                : {{ $allTasks->last()->finished_at ?? 'Not completed' }}</h4>

            </div>
            <div class="col-md-6">
                @if(empty($process->policy->image))
                    <img src="{{ asset('uploads/policy/no-image.png') }}" style="width: 100px; height: 100px" alt="">
                @else
                    <img src="{{ asset('uploads/policy/'. $process->policy->image) }}" style="width: 100px; height: 100px" alt="">
                @endif
            </div>
            </div>

            <hr>

            <a href="{{ route('process.index', ['policyId' => $process->policy->id]) }}" class="btn btn-primary">{{ trans('translation.general.task.back-to-process') }}</a>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.warning') }}</strong> {!! Session::get('error_message') !!}
                        </div>
                    @endif
                    @if(isset($task))
                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption">
                                    {{ trans('translation.general.tasks.active-task') }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th> {{ trans('translation.general.task.name') }} </th>
                                            <th> {{ trans('translation.general.task.phase') }} </th>
                                            <th> {{ trans('translation.general.task.description') }} </th>
                                            <th> {{ trans('translation.general.task.assignee') }} </th>
                                            <th width="21%"> {{ trans('translation.general.task.actions') }} </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td> {{ $task->xml_task_name }} </td>
                                            <td> {{ $task->phase }} </td>
                                            <td> {{ $task->description }} </td>
                                            <td> {{ $task->assignee ?? "--" }} </td>
                                            <td>
                                                @if((Auth::user()->group->name == $task->assignee) || empty($task->assignee) || ($task->assignee=='allgroup') || (Auth::user()->group->name == 'Pilot Administrators'))
                                                    <a type="button" href="{{ route('task.show', ['xmlTaskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'xmlTaskName' => $task->xml_task_name]) }}" class="btn btn-primary"><i class="fa fa-search"></i> {{ trans('translation.general.task.show') }}</a>
                                                @else
                                                    <div class="alert alert-warning" role="alert" style="margin-bottom: 0">
                                                        {{ trans('translation.general.task.not-authorized') }}
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                        <hr />
                        <div>
                            @if($processImage)
                                <div style="height: 250px; overflow:auto;"><img src="{{ asset('uploads/process/'.$processImage->image) }}" style="width:100%; height: auto; margin-bottom: 25px;" /></div>
                            @endif
                        </div>
                        <hr />

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                {{ trans('translation.general.tasks.all-tasks') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width= "10%">{{ trans('translation.general.task.name') }}</th>
                                        <th width= "8%">{{ trans('translation.general.task.status') }}</th>
                                        <th width= "7%" >{{ trans('translation.general.task-show.phase') }}</th>
                                        <th width= "30%">{{ trans('translation.general.tasks.description') }}</th>
                                        <th>{{ trans('translation.general.tasks.assignee') }}</th>
                                        <th width= "10%">{{ trans('translation.general.tasks.start-date') }}</th>
                                        <th width= "10%">{{ trans('translation.general.tasks.end-date') }}</th>
                                        <th width= "10%">{{ trans('translation.general.tasks.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($allTasks->count() > 0)
                                        @foreach($allTasks as $taskRow)
                                            <tr class="@if($taskRow->status == 2) success @endif">

                                                <td> {{ $taskRow->xml_task_name }} </td>
                                                <td>
                                                    @if($taskRow->status == 0)
                                                        {{ trans('translation.general.tasks.not-started') }}
                                                    @elseif($taskRow->status == 1)
                                                        {{ trans('translation.general.tasks.active-task') }}
                                                    @elseif($taskRow->status == 2)
                                                        {{ trans('translation.general.tasks.completed') }}
                                                    @else
                                                        ??
                                                    @endif
                                                </td>

                                                <td>{{ $taskRow->phase ?? "--" }}</td>
                                                <td>{{ $taskRow->description ?? "--" }}</td>
                                                <td>{{ $taskRow->assignee ?? "--" }}</td>
                                                <td>{{ $taskRow->started_at ?? "--" }}</td>
                                                <td>{{ $taskRow->finished_at ?? "--" }}</td>
                                                <td>
                                                    @if($taskRow->status == 2)
                                                        @if((Auth::user()->group->name == $taskRow->assignee) || empty($taskRow->assignee) || ($taskRow->assignee=='allgroup') || (Auth::user()->group->name == 'Pilot Administrators'))
                                                            <a type="button" href="{{ route('completedTaskShow', ['xmlTaskId' => $taskRow->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'xmlInstanceId' => $xmlInstanceId, 'xmlTaskName' => $taskRow->xml_task_name]) }}" class="btn btn-primary"><i class="fa fa-search"></i> {{ trans('translation.general.task.show') }}</a>
                                                        @else
                                                            <div class="alert alert-warning" role="alert" style="margin-bottom: 0">
                                                                {{ trans('translation.general.task.not-authorized') }}
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="alert alert-warning" role="alert" style="margin-bottom: 0">
                                                            {{ trans('translation.general.task.not-completed') }}
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"
                                                class="text-center">{{ trans('translation.general.task.task-not-found') }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
