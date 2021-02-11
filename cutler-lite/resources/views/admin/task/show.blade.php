@extends('admin.parent')

@section('title', $task->xml_task_name)

@section('css')
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="//cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
@endsection

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
            <!-- END PAGE BREADCRUMB -->
            <hr>
            <div class="row">

                <div class="col-md-6">
                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.policy-name') }}</span>: {{ $process->policy->name }}
                    </h4>
                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.policy-created-by') }}</span>: {{ $process->policy->user->name.' '.$process->policy->user->surname }}
                    </h4>
                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.policy-created-time') }}</span>: {{ $process->policy->created_at }}
                    </h4>
                </div>
                <div class="col-md-6">

                    @if(empty($policy->image))
                        <img src="{{ asset('uploads/policy/no-image.png') }}" style="width: 120px; height: auto" alt="">
                    @else
                        <img src="{{ asset('uploads/policy/'. $policy->image) }}" style="width: 120px; height: auto"
                             alt="">
                    @endif

                </div>
            </div>
            <hr>
            <div class="row">

                <div class="col-md-6">
                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.process-name') }}</span>: {{ $task->process_name }}
                    </h4>
                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.process-started-by') }}</span>: {{ $process->startedUser->name .' '. $process->startedUser->surname}}
                    </h4>
                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.process-started-time') }}</span>: {{ $process->started_at }}
                    </h4>
                </div>

                <div class="col-md-6">
                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.task-name') }}</span>:
                        <b>{{ $task->xml_task_name }}</b></h4>

                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.phase') }}</span>: {{ $task->phase }}
                    </h4>

                </div>
            </div>
            <hr>
            <div class="row">

                <div class="col-md-12">
                    <h4 style="line-height:30px;"><span
                            style="width:190px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.description') }}</span>: {{ $task->description }}
                    </h4>
                </div>
            </div>

            <hr>
            <a href="{{ route('task.index', ['xmlProcessId' => $process->xml_process_id, 'xmlInstanceId' => $process->xml_instance_id]) }}"
               class="btn btn-primary">{{ trans('translation.general.task-show.back-to-tasks') }}</a>
            <hr>

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-info"></i>
                                {{ trans('translation.general.task-show.task-info') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="mt-element-step">
                                <div class="row step-thin">
                                    <div
                                        class="col-md-12 col-xl-2 col-lg-2 col-lg-offset-1 bg-grey mt-step-col @if($task->phase == "Inform") done active @endif">
                                        {{--                                        <div class="mt-step-number bg-white font-grey">1</div>--}}
                                        <div
                                            class="mt-step-title uppercase font-grey-cascade">{{ trans('translation.general.task-show.inform') }}</div>
                                    </div>
                                    <div
                                        class="col-md-12 col-xl-2 col-lg-2 bg-grey mt-step-col @if($task->phase == "Advise") done active @endif" style="border-left: 1px solid #c0c0c0;">
                                        {{--                                        <div class="mt-step-number bg-white font-grey">2</div>--}}
                                        <div
                                            class="mt-step-title uppercase font-grey-cascade">{{ trans('translation.general.task-show.advise') }}</div>
                                    </div>
                                    <div
                                        class="col-md-12 col-xl-2 col-lg-2 bg-grey mt-step-col @if($task->phase == "Monitor") done active @endif" style="border-left: 1px solid #c0c0c0;">
                                        {{--                                        <div class="mt-step-number bg-white font-grey">3</div>--}}
                                        <div
                                            class="mt-step-title uppercase font-grey-cascade">{{ trans('translation.general.task-show.monitor') }}</div>
                                    </div>
                                    <div
                                        class="col-md-12 col-xl-2 col-lg-2 bg-grey mt-step-col @if($task->phase == "Evaluate") done active @endif" style="border-left: 1px solid #c0c0c0;">
                                        {{--                                        <div class="mt-step-number bg-white font-grey">4</div>--}}
                                        <div
                                            class="mt-step-title uppercase font-grey-cascade">{{ trans('translation.general.task-show.evaluate') }}</div>
                                    </div>
                                    <div
                                        class="col-md-12 col-xl-2 col-lg-2  bg-grey mt-step-col @if($task->phase == "Revise") done active @endif" style="border-left: 1px solid #c0c0c0;">
                                        {{--                                        <div class="mt-step-number bg-white font-grey">5</div>--}}
                                        <div
                                            class="mt-step-title uppercase font-grey-cascade">{{ trans('translation.general.task-show.revise') }}</div>
                                    </div>
                                </div>
                                @if(isset($allTasks))
                                    <div class="row step-thin">
                                        @php $taskList = array('Inform' => '', 'Advise' => '', 'Monitor' => '', 'Evaluate' => '', 'Revise' => ''); @endphp
                                        @if($allTasks->count() > 0)
                                            @foreach($allTasks as $taskRow)

                                                @if(isset($completedTaskShowPage))
                                                    @if($taskRow->xml_task_name == $task->xml_task_name)
                                                        @php
                                                            $taskList[$taskRow->phase] .= '<p class="text-center"
                                                               style="margin-top:10px; font-weight:bold; background-color: red; color: white; padding:5px; ">'.$taskRow->xml_task_name.'</p>'
                                                        @endphp
                                                    @else
                                                        @php
                                                            $taskList[$taskRow->phase] .= '<p class="text-center"
                                                               style="margin-top:10px; background-color: #3598dc; color:white; padding:5px;">'.$taskRow->xml_task_name.'</p>'
                                                        @endphp
                                                    @endif
                                                @else
                                                    @if($taskRow->status==1)
                                                        @php
                                                            $taskList[$taskRow->phase] .= '<p class="text-center"
                                                               style="margin-top:10px; font-weight:bold; background-color: red; color: white; padding:5px; ">'.$taskRow->xml_task_name.'</p>'
                                                        @endphp
                                                    @else
                                                        @php
                                                            $taskList[$taskRow->phase] .= '<p class="text-center"
                                                               style="margin-top:10px; background-color: #3598dc; color:white; padding:5px;">'.$taskRow->xml_task_name.'</p>'
                                                        @endphp
                                                    @endif
                                                @endif



                                            @endforeach
                                        @endif

                                        <div class="col-md-2 col-md-offset-1 ">
                                            {!! $taskList['Inform'] !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! $taskList['Advise'] !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! $taskList['Monitor'] !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! $taskList['Evaluate'] !!}
                                        </div>
                                        <div class="col-md-2">
                                            {!! $taskList['Revise'] !!}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{--                            @if(isset($renderedFormStatusCode))--}}
                            {{--                                @if($renderedFormStatusCode=='200')--}}
                            {{--                                    <hr/>--}}
                            {{--                                    {!! $renderedForm !!}--}}
                            {{--                                @endif--}}
                            {{--                            @endif--}}
                            {{--                            <hr>--}}

                            <?php
                            /*
                            <div class="mt-element-step">
                                <div class="row step-thin">
                                    @if($allTasks->count() > 0)
                                        @php $phaseNumber = 1 @endphp
                                        @foreach($allTasks as $taskRow)
                                            <div
                                                class="col-md-2 col-md-offset-1 bg-grey mt-step-col @if($taskRow->phase == $task->phase) done active @endif">
                                                <div class="mt-step-number bg-white font-grey">{{ $phaseNumber }}</div>
                                                <div
                                                    class="mt-step-title uppercase font-grey-cascade">{{ $taskRow->phase }}</div>
                                            </div>
                                            @php $phaseNumber++ @endphp
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row step-thin">
                                    @if($allTasks->count() > 0)
                                        @foreach($allTasks as $taskRow)
                                            <div class="col-md-2 col-md-offset-1 ">
                                                    <p class="text-center"
                                                       style="margin-top:10px; font-weight:bold; border:1px solid red; padding:5px; ">  {{ $taskRow->xml_task_name }}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <hr>
                            */
                            ?>

                            <div class="row">
                                <div class="col-md-3">
                                <!--  <button class="btn btn-info">{{ trans('translation.general.task-show.back') }}</button>-->
                                </div>
                                {{--                                @if(!isset($completedTaskShowPage))--}}
                                {{--                                    <div class="col-md-3 col-md-offset-6 text-right">--}}
                                {{--                                        @if($renderedFormStatusCode=="404")--}}
                                {{--                                            @if($task->last_task==0)--}}
                                {{--                                                <a href="javascript:finishAndNextTaskBtn('{{ route('task.finishAndNextTask', ['taskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'processName' => $task->process_name, 'instanceId' => $task->instance_id]) }}')"--}}
                                {{--                                                   class="btn btn-success"--}}
                                {{--                                                   id="finishAndNextTaskBtn">{{ trans('translation.general.task-show.finish-task-next') }}</a>--}}
                                {{--                                            @endif--}}
                                {{--                                            <a href="javascript:finishTaskBtn('{{ route('task.finish', ['taskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'processName' => $task->process_name, 'instanceId' => $task->instance_id]) }}')"--}}
                                {{--                                               class="btn btn-success"--}}
                                {{--                                               id="finishTaskBtn">{{ trans('translation.general.task-show.finish-task') }}</a>--}}
                                {{--                                        @else--}}
                                {{--                                            <a href="javascript:formSubmitAndNextTaskBtn();"--}}
                                {{--                                               class="btn btn-success"--}}
                                {{--                                               id="formSubmitAndNextTaskBtn">{{ trans('translation.general.task-show.form-submit-next') }}</a>--}}
                                {{--                                        @endif--}}

                                {{--                                    </div>--}}
                                {{--                                @endif--}}

                                <script>
                                    var btnstatus = 0;

                                    function finishAndNextTaskBtn(url) {
                                        if (window.btnstatus === 0) {
                                            $("#finishAndNextTaskBtn").html('<i class="fa fa-spinner fa-spin"></i>' + $("#finishAndNextTaskBtn").text());
                                            window.location = url;
                                            window.btnstatus = 1;
                                        }
                                    }

                                    function finishTaskBtn(url) {
                                        if (window.btnstatus === 0) {
                                            $("#finishTaskBtn").html('<i class="fa fa-spinner fa-spin"></i>' + $("#finishTaskBtn").text());
                                            window.location = url;
                                            window.btnstatus = 1;
                                        }
                                    }

                                    function formSubmitAndNextTaskBtn() {
                                        if (window.btnstatus === 0) {
                                            $("#formSubmitAndNextTaskBtn").html('<i class="fa fa-spinner fa-spin"></i>' + $("#formSubmitAndNextTaskBtn").text());
                                            document.getElementById('generatedForm').submit();
                                            window.btnstatus = 1;
                                        }
                                    }
                                </script>

                            </div>

                        </div>

                    </div>
                    <hr>

                    @if(isset($processImage))
                        <div>
                            <div style="height: 250px; overflow:auto;"><img
                                    src="{{ asset('uploads/process/'.$processImage->image) }}"
                                    style="width:100%; height: auto; margin-bottom: 25px;"/></div>
                        </div>
                        <hr>
                    @endif

                    @if(isset($widget))
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-pie-chart"></i>
                                    {{ trans('translation.general.task-show.widgets') }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <div class="row">
                                        <?php
                                        /*
                                        <div class="form-group " style="padding:10px 30px 0px 30px ; ">
                                            <label>{{ trans('translation.general.task-show.date-filter') }}</label>
                                            <div class="mt-radio-inline">
                                                <form method="post">
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <label class="mt-radio" style="margin-top: 7px;">
                                                                <input  type="radio" name="w4Selection" value="option1"
                                                                        onclick="go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $widget->dashboard_id }}?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-7d%2Cto%3Anow))')"
                                                                        @if(!is_null($taskDateFilter))
                                                                            @if($taskDateFilter->last_selection == '7d') checked @endif
                                                                        @endif
                                                                >
                                                                {{ trans('translation.general.task-show.last-seven') }}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio" style="margin-top: 7px;">
                                                                <input type="radio" name="w4Selection" value="option2"
                                                                       onclick="go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $widget->dashboard_id }}?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-1M%2Cto%3Anow))')"
                                                                       @if(!is_null($taskDateFilter))
                                                                       @if($taskDateFilter->last_selection == '1m') checked @endif
                                                                    @endif
                                                                >
                                                                {{ trans('translation.general.task-show.last-month') }}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio" style="margin-top: 7px;">
                                                                <input type="radio" name="w4Selection" value="option3"
                                                                       onclick="go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $widget->dashboard_id }}?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-1y%2Cto%3Anow))')"
                                                                       @if(!is_null($taskDateFilter))
                                                                       @if($taskDateFilter->last_selection == '1y') checked @endif
                                                                    @endif
                                                                >
                                                                {{ trans('translation.general.task-show.last-1-year') }}
                                                                <span></span>
                                                            </label>
                                                            <label class="mt-radio" style="margin-top: 7px;">
                                                                <input type="radio" name="w4Selection" value="option3"
                                                                       onclick="go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $widget->dashboard_id }}?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-3y%2Cto%3Anow))')"
                                                                       @if(!is_null($taskDateFilter))
                                                                       @if($taskDateFilter->last_selection == '3y') checked @endif
                                                                    @endif
                                                                >
                                                                {{ trans('translation.general.task-show.last-year') }}
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form method="post">
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="row">
                                                                    <select class="form-control" id="filter_type">
                                                                        <option
                                                                            value="">{{ trans('translation.general.task-show.choose') }}</option>
                                                                        <option
                                                                            value="Last">{{ trans('translation.general.task-show.last') }}</option>
                                                                        <option
                                                                            value="Next">{{ trans('translation.general.task-show.next') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="number" id="time_number"
                                                                       class="form-control"
                                                                       aria-label="Quick time value" value="15">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="row">
                                                                    <select class="form-control" id="time_type">
                                                                        <option
                                                                            value="s">{{ trans('translation.general.task-show.seconds') }}</option>
                                                                        <option value="m"
                                                                                selected>{{ trans('translation.general.task-show.minutes') }}</option>
                                                                        <option
                                                                            value="h">{{ trans('translation.general.task-show.hours') }}</option>
                                                                        <option
                                                                            value="d">{{ trans('translation.general.task-show.days') }}</option>
                                                                        <option
                                                                            value="w">{{ trans('translation.general.task-show.weeks') }}</option>
                                                                        <option
                                                                            value="M">{{ trans('translation.general.task-show.months') }}</option>
                                                                        <option
                                                                            value="y">{{ trans('translation.general.task-show.years') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button type="button" class="btn btn-success"
                                                                        onclick="timeFilter()">{{ trans('translation.general.task-show.apply') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="page-toolbar " style=" margin-bottom:5px;">
                                                    <!--   <input class="input-mini active" type="text" name="daterangepicker_start" value="">-->

                                                    <div id="daterange" data-display-range="0"
                                                         class="pull-right btn btn-fit-height green"
                                                         data-placement="left"
                                                    >
                                                        <i class="icon-calendar"></i>&nbsp;
                                                        <span class="thin uppercase hidden-xs"></span>&nbsp;
                                                        <i class="fa fa-angle-down"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12"><h4 class="dateview" style="display:none;"><span
                                                        style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.date-filter') }}</span>
                                                    : <span class="StartDateVal"></span> - <span
                                                        class="EndDateVal"></span></h4></div>
                                            <hr>
                                        </div>
                                        */
                                        ?>

                                        {{--                                        <iframe class="widget" scrolling="yes"--}}
                                        {{--                                                style="width:100%; height: 1400px; padding: 0 30px 30px 30px;" id="w4"--}}
                                        {{--                                                src="{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $widget->dashboard_id }}?embed=true&_g=(refreshInterval%3A(pause%3A!f%2Cvalue%3A900000)%2Ctime%3A(from%3Anow-3y%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t))"--}}
                                        {{--                                                frameborder="0" ></iframe>--}}

                                        <iframe class="widget" scrolling="yes"
                                                style="width:100%; height: 1400px; padding: 0 30px 30px 30px;" id="w4"
                                                src="{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $widget->dashboard_id }}?_g=(filters:!(),refreshInterval:(pause:!t,value:0))&_a=(description:'',filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!f,title:'Elastic%20View%20of%20MITRE%20Round%202%20Eval%20Results',viewMode:view)"
                                                frameborder="0"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($task->kafka==1)

                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-pie-chart"></i>
                                    {{ trans('translation.general.task-show.filter') }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                {!! Form::label('name', trans('translation.general.task.time-range'), ['class' => 'col-md-12'])  !!}
                                                <div class="col-md-4">
                                                    <div class="input-group input-large date-picker input-daterange"
                                                         data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                                        <span class="input-group-addon"> From </span>
                                                        <input type="text" class="form-control" name="from"
                                                               placeholder="YYYY-mm-dd" id="topic_from">
                                                        <span class="input-group-addon"> to </span>
                                                        <input type="text" class="form-control" name="to"
                                                               placeholder="YYYY-mm-dd"
                                                               id="topic_to">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5 @if($errors->has('name')) has-error @endif">
                                            {!! Form::label('name', trans('translation.general.task.keyword'), ['class' => 'col-md-12'])  !!}
                                            <div class="col-md-12">
                                                {!! Form::text('name', null, ['id' => 'topic_keyword', 'class' => 'form-control', 'placeholder' => 'Düden...']) !!}
                                                @if($errors->has('name'))
                                                    <label class="control-label">{{ $errors->first('name') }}</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-2 @if($errors->has('name')) has-error @endif">
                                            {!! Form::label('name', trans('translation.general.task.run'), ['class' => 'col-md-12'])  !!}
                                            <div class="col-md-12">
                                                <button type="button" class="btn blue" onclick="runPython()"><i
                                                        class="fa fa-cogs"></i> {{ trans('translation.general.task.run') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr/>
                                            <button type="button" class="btn green" onclick="kafkaKeywords()"><i
                                                    class="fa fa-refresh"></i> {{ trans('translation.general.task.re-check') }}
                                            </button>
                                            <div class="pythonreturn"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                    @endif

                    @if($task->maps==1)
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-map"></i>
                                    {{ trans('translation.general.task.map') }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <iframe class="widget"
                                                    style="width:100%; height: 800px; padding: 0 30px 30px 30px;"
                                                    id="imac"
                                                    src="{{ $settings->maps_iframe_url }}"
                                                    frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif

                    @if(($task->link1==1) && (isset($settings->link_title_1)) && (isset($settings->link_1)))
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-map"></i>
                                    {{ $settings->link_title_1 }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <iframe class="widget"
                                                    style="width:100%; height: 800px; padding: 0 30px 30px 30px;"
                                                    id="imac"
                                                    src="{{ $settings->link_1 }}"
                                                    frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif

                    @if(($task->link2==1) && (isset($settings->link_title_1)) && (isset($settings->link_1)))
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-map"></i>
                                    {{ $settings->link_title_2 }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <iframe class="widget"
                                                    style="width:100%; height: 800px; padding: 0 30px 30px 30px;"
                                                    id="imac"
                                                    src="{{ $settings->link_2 }}"
                                                    frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif

                    @if(($task->link3==1) && (isset($settings->link_title_1)) && (isset($settings->link_1)))
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-map"></i>
                                    {{ $settings->link_title_3 }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <iframe class="widget"
                                                    style="width:100%; height: 800px; padding: 0 30px 30px 30px;"
                                                    id="imac"
                                                    src="{{ $settings->link_3 }}"
                                                    frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-comment"></i>
                                {{ trans('translation.general.task.review') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mt-comments" id="taskComments"
                                             style="max-height: 300px; overflow: auto">
                                            @if($taskComments->count() > 0)
                                                @foreach($taskComments as $taskComment)
                                                    <div class="mt-comment">
                                                        <div class="mt-comment-body">
                                                            <div class="mt-comment-info">
                                                                <span
                                                                    class="mt-comment-author">{{ $taskComment->user()->first()->name.' '.$taskComment->user()->first()->surname }}</span>
                                                                <span
                                                                    class="mt-comment-date">{{ \Carbon\Carbon::parse($taskComment->created_at)->format('Y-M-d H:i') }}</span>
                                                            </div>
                                                            <div
                                                                class="mt-comment-text">
                                                                <strong>{{ trans('translation.general.statistic.task') }}:</strong> {{ $taskComment->xml_task_name }}<br/>
                                                                <strong>{{ trans('translation.general.task.comment') }}:</strong> {!! $taskComment->comment !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div style="max-height: 280px" class="text-center">
                                                    <p style="font-size: 25px">{{ trans('translation.general.task-show.comment-not-found') }}</p>
                                                </div>
                                            @endif
                                        </div>

                                        @if(empty($completedTaskShowPage))
                                            <div class="form-group" style="margin-top: 15px">
                                                {!! Form::hidden('xmlTaskId', $task->xml_task_id, ['id' => 'xmlTaskId']); !!}
                                                {!! Form::hidden('xmlProcessId', $xmlProcessId, ['id' => 'xmlProcessId']); !!}
                                                {!! Form::hidden('xmlTaskName', $task->xml_task_name, ['id' => 'xmlTaskName']); !!}
                                                {!! Form::hidden('instanceId', $task->instance_id, ['id' => 'instanceId']); !!}
                                                {!! Form::label('comment', trans('translation.general.task.comment'))  !!}
                                                {!! Form::textarea('comment', null, ['id' => 'comment', 'class' => 'form-control', 'rows' => 3]) !!}
                                            </div>
                                            <div class="form-group">
                                                <button type="button" onclick="addComment()" class="btn green">{{ trans('translation.general.process-design.submit') }}
                                                </button>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-info"></i>
                                {{ trans('translation.general.task-show.task-info') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if(isset($renderedFormStatusCode))
                                @if($renderedFormStatusCode=='200')
                                    {!! $renderedForm !!}
                                @endif
                            @endif
                            <hr>

                            <?php
                            /*
                            <div class="mt-element-step">
                                <div class="row step-thin">
                                    @if($allTasks->count() > 0)
                                        @php $phaseNumber = 1 @endphp
                                        @foreach($allTasks as $taskRow)
                                            <div
                                                class="col-md-2 col-md-offset-1 bg-grey mt-step-col @if($taskRow->phase == $task->phase) done active @endif">
                                                <div class="mt-step-number bg-white font-grey">{{ $phaseNumber }}</div>
                                                <div
                                                    class="mt-step-title uppercase font-grey-cascade">{{ $taskRow->phase }}</div>
                                            </div>
                                            @php $phaseNumber++ @endphp
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row step-thin">
                                    @if($allTasks->count() > 0)
                                        @foreach($allTasks as $taskRow)
                                            <div class="col-md-2 col-md-offset-1 ">
                                                    <p class="text-center"
                                                       style="margin-top:10px; font-weight:bold; border:1px solid red; padding:5px; ">  {{ $taskRow->xml_task_name }}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <hr>
                            */
                            ?>

                            <div class="row">
                                <div class="col-md-3">
                                <!--  <button class="btn btn-info">{{ trans('translation.general.task-show.back') }}</button>-->
                                </div>
                                @if(!isset($completedTaskShowPage))
                                    <div class="col-md-3 col-md-offset-6 text-right">
                                        @if($renderedFormStatusCode=="404")
                                            @if($task->last_task==0)
                                                <a href="javascript:finishAndNextTaskBtn('{{ route('task.finishAndNextTask', ['taskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'processName' => $task->process_name, 'instanceId' => $task->instance_id]) }}')"
                                                   class="btn btn-success"
                                                   id="finishAndNextTaskBtn">{{ trans('translation.general.task-show.finish-task-next') }}</a>
                                            @endif
                                            <a href="javascript:finishTaskBtn('{{ route('task.finish', ['taskId' => $task->xml_task_id, 'xmlProcessId' => $xmlProcessId, 'processName' => $task->process_name, 'instanceId' => $task->instance_id]) }}')"
                                               class="btn btn-success"
                                               id="finishTaskBtn">{{ trans('translation.general.task-show.finish-task') }}</a>
                                        @else
                                            <a href="javascript:formSubmitAndNextTaskBtn();"
                                               class="btn btn-success"
                                               id="formSubmitAndNextTaskBtn">{{ trans('translation.general.task-show.form-submit-next') }}</a>
                                        @endif

                                    </div>
                                @endif

                                <script>
                                    var btnstatus = 0;

                                    function finishAndNextTaskBtn(url) {
                                        if (window.btnstatus === 0) {
                                            $("#finishAndNextTaskBtn").html('<i class="fa fa-spinner fa-spin"></i>' + $("#finishAndNextTaskBtn").text());
                                            window.location = url;
                                            window.btnstatus = 1;
                                        }
                                    }

                                    function finishTaskBtn(url) {
                                        if (window.btnstatus === 0) {
                                            $("#finishTaskBtn").html('<i class="fa fa-spinner fa-spin"></i>' + $("#finishTaskBtn").text());
                                            window.location = url;
                                            window.btnstatus = 1;
                                        }
                                    }

                                    function formSubmitAndNextTaskBtn() {
                                        if (window.btnstatus === 0) {
                                            $("#formSubmitAndNextTaskBtn").html('<i class="fa fa-spinner fa-spin"></i>' + $("#formSubmitAndNextTaskBtn").text());
                                            document.getElementById('generatedForm').submit();
                                            window.btnstatus = 1;
                                        }
                                    }
                                </script>

                            </div>

                        </div>

                    </div>
                </div>
                <!-- END PAGE BASE CONTENT -->
            </div>
            <!-- END CONTENT BODY -->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ admin_asset('global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ admin_asset('global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ admin_asset('global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ admin_asset('global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ admin_asset('global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ admin_asset('global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ admin_asset('pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
            type="text/javascript"></script>
    <script>
        $(document).ready(function () {

            $("input[name='daterangepicker_start']").val("2020-08-16");
            @php
                if($taskDateFilter){
                    $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$widget->dashboard_id;

                    if (is_null($taskDateFilter->last_selection)) {
                        if($taskDateFilter->start_date!=''){
                            $time = "from:'" . $taskDateFilter->start_date . "',to:'" . $taskDateFilter->end_date . "'";
                            $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$widget->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(".$time."))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                        } else {
                            $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$widget->dashboard_id;
                        }
                    } else {
                        switch ($taskDateFilter->last_selection) {
                            case "7d":
                                $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$widget->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(from%3Anow-7d%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                break;
                            case "1M":
                                $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$widget->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(from%3Anow-1M%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                break;
                                case "1y":
                                    $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$widget->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(from%3Anow-1y%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                    break;
                                    case "3y":
                                        $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$widget->dashboard_id."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(from%3Anow-3y%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                        break;
                        }
                    }
                } else {
                    $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$widget->dashboard_id;
                }

            @endphp

            go("{!! $iframeUrl !!}");
        });

        $(function () {
            minDateFilter = "";
            maxDateFilter = "";

            $("#daterange").daterangepicker({
                timePicker: true,
                startDate: @if(isset($taskDateFilter->start_date))'{{ $taskDateFilter->start_date }}'@else moment().startOf('hour') @endif,
                endDate: @if(isset($taskDateFilter->end_date))'{{ $taskDateFilter->end_date }}'@else moment().startOf('hour').add(32, 'hour') @endif,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $(".applyBtn").click(function () {
                $('.dateview').css('display', 'block');
                var inputStartVal = $("input[name='daterangepicker_start']").val();
                var inputEndVal = $("input[name='daterangepicker_end']").val();
                $('.StartDateVal').html(inputStartVal);
                $('.EndDateVal').html(inputEndVal);
                var time_url = "from:'" + inputStartVal + "T00:00:00.000Z',to:'" + inputEndVal + "T00:00:00:00.000Z'";
                go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $widget->dashboard_id }}?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(' + time_url + '))');
            });
        });

        function go(loc) {
            document.getElementById('w4').src = loc;
        }

        function timeFilter() {
            var filter_type = $("#filter_type").val();
            var time_number = $("#time_number").val();
            var time_type = $("#time_type").val();
            var time_url = '';

            if (filter_type == 'Last') {
                time_url = 'from%3Anow-' + time_number + time_type + '%2Cto%3Anow';
            } else {
                time_url = 'from%3Anow%2Cto%3Anow%2B' + time_number + time_type;
            }

            go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $widget->dashboard_id }}?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(' + time_url + '))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t))');

            return filter_type;
        }

        function runPython() {
            var start_date = $("#topic_from").val();
            var end_date = $("#topic_to").val();
            var keyword = $("#topic_keyword").val();

            if ((start_date === '') || (end_date === '') || (keyword === '')) {
                alert("{{ trans('general.task-show.run-python-required-fields') }}");
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('python.kafkaPost')}}",
                    type: "POST",
                    data: {
                        xml_task_id: '{{ $task->xml_task_id }}',
                        start_date: start_date,
                        end_date: end_date,
                        keyword: keyword
                    },
                    success: function (response) {
                        $("#topic_from").val('');
                        $("#topic_to").val('');
                        $("#topic_keyword").val('');
                        kafkaKeywords();
                    }
                });
            }
        }

        function kafkaKeywords() {
            $(".pythonreturn").html('<i class="fa fa-spin fa-spinner"></i>');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('python.kafkaKeywords')}}",
                type: "POST",
                data: {
                    xml_task_id: '{{ $task->xml_task_id }}'
                },
                success: function (response) {
                    $('.pythonreturn').html(response);
                }
            });
        }

        function addComment() {
            var xmlTaskId = $('#xmlTaskId').val();
            var xmlProcessId = $('#xmlProcessId').val();
            var instanceId = $('#instanceId').val();
            var xmlTaskName = $('#xmlTaskName').val();
            var comment = $('#comment').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('task.addComment')}}",
                type: "POST",
                data: {
                    xmlTaskId: xmlTaskId,
                    xmlProcessId: xmlProcessId,
                    instanceId: instanceId,
                    xmlTaskName: xmlTaskName,
                    comment: comment,
                },
                success: function (response) {
                    $('#taskComments').html(response);
                    $('#comment').val("");
                    var elem = document.getElementById('taskComments');
                    elem.scrollTop = elem.scrollHeight;
                }
            });
        }

        $(document).ready(function () {
            var elem = document.getElementById('taskComments');
            elem.scrollTop = elem.scrollHeight;
            kafkaKeywords();
        });
    </script>
@endsection
