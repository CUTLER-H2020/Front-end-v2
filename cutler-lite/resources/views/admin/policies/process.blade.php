@extends('admin.parent')

@section('title', trans('translation.general.policies.policies'))

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'process.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>{!! $page['title'] !!}</h1>
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
                    <span class="active">{!! $page['title'] !!}</span>
                </li>
            </ul>
            <hr>
            <h4><span style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.policy-name') }}</span> : {{ Session::get('policyName') }}</h4>
            <hr>

            @if(!Session::has('policyName'))
                <button onclick="javascript:;" class="tooltips btn btn-primary disabled" data-placement="right" data-original-title="You can't start process without choosing a policy" style="margin-bottom: 5px">
                    <i class="fa fa-plus"></i>
                    {{ trans('translation.general.process.start-new-process') }}
                </button>
            @else
                <button onclick="startNewProcessModal()" class="btn btn-primary" style="margin-bottom: 5px">
                    <i class="fa fa-plus"></i>
                    {{ trans('translation.general.process.start-new-process') }}
                </button>
            @endif
            <!-- END PAGE BREADCRUMB -->
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif
                    @if(Session::has('session_success'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('session_success') !!}
                        </div>
                    @endif
                    @if(Session::has('policyName'))
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    Process List
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th> {{ trans('translation.general.process.process-name') }} </th>
                                         <!--   <th> İnstance İd </th>-->
                                            <th> {{ trans('translation.general.process.phase') }} </th>
                                            <th> Created Date </th>
                                            <th width="21%"> {{ trans('translation.general.process.actions') }} </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($processes->count() > 0)
                                            @foreach($processes as $process)
                                                <tr>
                                                    <td> {{ $process->xml_process_name }} </td>
                                                  <!--  <td>{{ $process->xml_process_id}}</td>-->
                                                    <td> {{ $process->activeTask->phase ?? '-' }} </td>
                                                    <td> {{ \Carbon\Carbon::parse($process->created_at)->format('d-m-Y') .' / '. \Carbon\Carbon::parse($process->created_at)->format('H:i') }} </td>
                                                    <td>
                                                        <a type="button" href="{{ route('task.index', ['instanceId' => $process->xml_process_id]) }}" class="btn btn-primary"><i class="fa fa-forward"></i> Go To Task</a>
                                                        <a type="button" href="" class="btn btn-primary disabled" style="text-decoration: line-through"><i class="fa fa-pencil"></i> {{ trans('translation.general.edit') }}</a>
                                                        <a type="button" href="" class="btn btn-danger disabled" style="text-decoration: line-through"><i class="fa fa-trash"></i> {{ trans('translation.general.delete') }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">{{ trans('translation.general.process.process-not-found') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach($policies as $policy)
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        {{ $policy->name }} - {!! $page['title'] !!}
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th> {{ trans('translation.general.process.process-id') }} </th>
                                                <th> {{ trans('translation.general.process.process-name') }} </th>
                                                <th> {{ trans('translation.general.process.phase') }} </th>
                                                <th width="21%"> {{ trans('translation.general.process.actions') }} </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($policy->processes->count() > 0)
                                                @foreach($policy->processes as $process)
                                                    <tr>
                                                        <td> {{ $process->xml_process_id }} </td>
                                                        <td> {{ $process->xml_process_name }} </td>
                                                        <td> {{ $process->activeTask->phase ?? '-' }} </td>
                                                        <td>
                                                            <a type="button" href="{{ route('task.index', ['instanceId' => $process->xml_process_id]) }}" class="btn btn-primary"><i class="fa fa-forward"></i> {{ trans('translation.general.process.go-to-task') }}</a>
                                                            <a type="button" href="" class="btn btn-primary disabled" style="text-decoration: line-through"><i class="fa fa-pencil"></i> {{ trans('translation.general.edit') }}</a>
                                                            <a type="button" href="" class="btn btn-danger disabled" style="text-decoration: line-through"><i class="fa fa-trash"></i> {{ trans('translation.general.delete') }}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">{{ trans('translation.general.process.process-not-found') }}</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->
        </div>
        <!-- END CONTENT BODY -->
    </div>

    <div id="start-new-process-modal-div"></div>
@endsection

@section('js')
    <script>
        function startNewProcessModal() {
            buttonOnClick();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('startNewProcessModal')}}",
                type: "POST",
                data: {1:1},
                success: function (response) {
                    $('#start-new-process-modal-div').html(response);
                    $('#startNewProcessModal').modal();
                }
            });

            {{--var xmlHttp = new XMLHttpRequest();--}}
            {{--var url = "http://{{ $settings->camunda_ip }}:{{ $settings->camunda_port }}/engine-rest/process-definition";--}}
            {{--xmlHttp.onreadystatechange = function () {--}}
            {{--    var processDefinition = JSON.parse(this.responseText);--}}
            {{--    var buttons = "";--}}
            {{--    for(i = 0; i < processDefinition.length; i++){--}}
            {{--        buttons += "<button onclick=\"startNewProcess('"+ processDefinition[i].id +"'\,'"+ processDefinition[i].name +"')\" class=\"btn btn-primary btn-lg btn-block\">"+ processDefinition[i].name +"</button>";--}}
            {{--    }--}}
            {{--    $('#buttons-div').html(buttons);--}}
            {{--    $('#exampleModal').modal();--}}
            {{--};--}}
            {{--xmlHttp.open("GET", url, true);--}}
            {{--xmlHttp.send();--}}
        }

        function startNewProcess(processId,processName) {
            var policyId = "{{ $policyId }}";
            var policyName = "{{ $policyName }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('startNewProcess')}}",
                type: "POST",
                dataType: "JSON",
                data: {processId: processId, processName: processName, policyId: policyId, policyName: policyName},
                success: function (response) {
                    $.getJSON( 'http://{{ $settings->camunda_ip }}:{{ $settings->camunda_port }}/engine-rest/process-definition/' + processId + '/xml',function(data,status){
                        var parser = new DOMParser();
                        var xmlDoc = parser.parseFromString(data.bpmn20Xml, "text/xml");
                        var dataIdList = xmlDoc.getElementsByTagName("bpmn:userTask");
                        $.each(dataIdList,function(key,val){
                            console.log("Name : "+val.attributes["name"].nodeValue+", ID : "+val.attributes["id"].nodeValue+", Camunda : "+val.attributes["camunda:assignee"].nodeValue);
                            let xmlName = val.attributes["name"].nodeValue;
                            let xmlTaskID = val.attributes["id"].nodeValue;

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: "{{ route('writeAllTasksToDatabase')}}",
                                type: "POST",
                                data: {xml_name: xmlName, xml_task_id: response.task.xml_task_id, instance_id: response.process.xml_process_id, process_name: processName},
                                success: function (response) {}
                            });

                        });
                    });

                    $('#buttons-div').html("<div class='text-center' style='margin-top: 10px'><i class=\"fa fa-spinner fa-pulse fa-3x fa-fw\"></i><p>{{ trans('translation.general.process.is-starting') }}</p></div>");

                    setTimeout(function () {
                        $('#exampleModal').modal('hide');
                        alert("Created new process");
                        window.location.reload();
                    }, 3000)
                }
            });
        }

        function buttonOnClick() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('buttonOnClick')}}",
                type: "POST",
                dataType: "JSON",
                data: {action: "button_click"},
                success: function (response) {}
            });
        }
    </script>
@endsection
