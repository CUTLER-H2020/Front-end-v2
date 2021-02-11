@extends('admin.parent')

@section('title', trans('translation.general.policies.policies'))

@section('css')
<link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="//cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('sidebar')
    @include('admin.partials.sidebar', ['active' => 'policies.index'])
@endsection

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEAD-->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1>{{ trans('translation.general.policies.policies') }}</h1>
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
                    <span class="active">{{ trans('translation.general.policies.policies') }}</span>
                </li>
            </ul>
            @if(hasPermission('policy.create'))
                <a href="{{ route('policy.create') }}" class="btn btn-primary" style="margin-bottom: 5px"><i class="fa fa-plus"></i>{{ trans('translation.general.policies.add-new-policy') }}</a>
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
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                {{ trans('translation.general.policies.policies') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table display nowrap" id="data1" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th> {{ trans('translation.general.policies.image') }} </th>
                                        <th> {{ trans('translation.general.policies.name') }} </th>
                                        <th> {{ trans('translation.general.policies.feature') }} </th>
                                        <th> {{ trans('translation.general.policies.goal') }} </th>
                                        <th> {{ trans('translation.general.policies.action') }} </th>
                                        <th> {{ trans('translation.general.policies.impact') }} </th>
                                        <th>{{ trans('translation.general.process.created-date') }}</th>
                                        <th>{{ trans('translation.general.process.created-by') }}</th>
                                        <th width="23%"> {{ trans('translation.general.policies.transactions') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($policies->count() > 0)
                                        @foreach($policies as $policy)
                                            <tr>
                                                <td width="10%" >
                                                    @if(empty($policy->image))
                                                        <img src="{{ asset('uploads/policy/no-image.png') }}" style="width: 135px; height: 135px" alt="">
                                                    @else
                                                        <img src="{{ asset('uploads/policy/'. $policy->image) }}" style="width: 135px; height: 135px" alt="">
                                                    @endif
                                                </td>
                                                <td width="15%" > {{ $policy->name }} </td>
                                                <td width="15%" > {{ $policy->feature }} </td>
                                                <td width="15%"> {{ $policy->goal }} </td>
                                                <td width="15%"> {{ $policy->action }} </td>
                                                <td width="15%"> {{ $policy->impact }} </td>
                                                <td width="15%"> {{ \Carbon\Carbon::parse($policy->created_at)->format('d-m-Y H:i') }} </td>
                                                <td width="15%"> {{ $policy->user->name.' '.$policy->user->surname }} </td>
                                                <td width="10%">
{{--                                                    <a type="button" href="{{ route('policy.goToProcess', ['policyId' => $policy->id, 'policyName' => $policy->name]) }}" class="btn btn-success"><i class="fa fa-forward"></i> Go To Process</a>--}}
                                                    @if(hasPermission('start-process'))
                                                        <a type="button" style="width: 100%" onclick="startNewProcessModal('{{ $policy->id }}')" class="btn btn-success"><i class="fa fa-forward"></i> {{ trans('translation.general.process.start-new-process') }}</a>
                                                    @endif
                                                    @if(hasPermission('process.index'))
                                                        <a type="button" style="width: 100%" href="{{ route('process.index', $policy->id) }}" class="btn btn-primary @if($policy->startedProcesses->count() == 0) disabled @endif" @if($policy->startedProcesses->count() == 0) disabled @endif><i class="fa fa-bars"></i> {{ trans('translation.general.process.process-list') }}</a>
                                                    @endif
                                                    @if(hasPermission('policy.edit'))
                                                        <a type="button" style="width: 100%" href="{{ route('policy.edit', $policy->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> {{ trans('translation.general.edit') }} </a>
                                                    @endif
                                                    @if(hasPermission('policy.destroy'))
                                                        <a type="button" style="width: 100%" href="{{ route('policy.destroy', $policy->id) }}" class="btn btn-danger delete-button @if($policy->startedProcesses->count() != 0) disabled @endif" @if($policy->startedProcesses->count() != 0) disabled @endif><i class="fa fa-trash"></i> {{ trans('translation.general.delete') }} </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">{{ trans('translation.general.policies.policy-not-found') }}</td>
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
    <div id="start-new-process-modal-div"></div>
@endsection

@section('js')
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js" type="text/javascript"></script>
<script>
    var btnstatus = 0;

    $(document).ready( function () {
        <?php
        if (Session::has('error_message')){
        ?>
        Swal.fire({
            title: '{{ trans('translation.general.warning') }}',
            text: "{{ trans('translation.general.not-select-policy') }}",
            icon: 'warning',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ trans('translation.general.okey') }}',
        });
        <?php
        }
        ?>
        $('#data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            columnDefs: [
                { "width": "5px", "targets": [0,1] },
            ],
            ordering: true,
            pageLength: 50
        });
    });

    function startNewProcessModal(policyId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('startNewProcessModal')}}",
            type: "POST",
            data: {policyId:policyId},
            success: function (response) {
                $('#start-new-process-modal-div').html(response);
                $('#startNewProcessModal').modal({backdrop: 'static', keyboard: false});
            }
        });
    }

    function test(){
        $.getJSON( 'http://92.45.59.250:8004/engine-rest/process-definition/demo_id_6:1:016bf046-9100-11ea-8bc1-0a0027000002/xml',function(data,status){
            var parser = new DOMParser();
            var xmlDoc = parser.parseFromString(data.bpmn20Xml, "text/xml");
            var dataIdList = xmlDoc.getElementsByTagName("bpmn:userTask");
            console.log(dataIdList);
            $.each(dataIdList,function(key,val){
                console.log("Name : "+val.attributes["name"].nodeValue+", ID : "+val.attributes["id"].nodeValue+", Camunda : "+val.attributes["camunda:assignee"].nodeValue);
                let xmlName = val.attributes["name"].nodeValue;
                let xmlTaskID = val.attributes["id"].nodeValue;
                let phase = val.getElementsByTagName("camunda:inputParameter")[0].innerHTML;
                let description = val.getElementsByTagName("camunda:inputParameter")[1].innerHTML;

                //console.log(phase+" => "+description);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('writeAllTasksToDatabase')}}",
                    type: "POST",
                    data: {xml_task_name: xmlName, xml_task_id: response.task.xml_task_id, definitionId: response.process.xml_definition_id, instanceId: response.process.xml_instance_id , process_name: processName, phase: response.task.phase, response: response},
                    success: function (response) {}
                });

            });
        });
    }

    function startNewProcess(processId, processKey, processName) {
        if(window.btnstatus===0){
            $("#startNewProcessModal .modal-body").html('<div class="text-center" style="margin-top: 10px"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><p>{{ trans('translation.general.process.is-starting') }}</p></div>');
            window.btnstatus = 1;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('startNewProcess')}}",
                type: "POST",
                dataType: "JSON",
                data: {processId: processId, processKey:processKey, processName: processName},
                success: function (response) {
                    //$.getJSON( 'http://{{ $settings->camunda_ip }}:{{ $settings->camunda_port }}/engine-rest/process-definition/' + processId + '/xml',function(data,status){
                    $.getJSON('{{ route('startNewProcessByPass') }}?processId='+processId,function(data,status){
                        var parser = new DOMParser();
                        var xmlDoc = parser.parseFromString(data.bpmn20Xml, "text/xml");
                        var dataIdList = xmlDoc.getElementsByTagName("bpmn:userTask");
                        console.log(dataIdList);
                        $.each(dataIdList,function(key,val){
                            console.log("Name : "+val.attributes["name"].nodeValue+", ID : "+val.attributes["id"].nodeValue+", Camunda : "+val.attributes["camunda:assignee"].nodeValue);
                            let xmlName = val.attributes["name"].nodeValue;
                            let xmlTaskID = val.attributes["id"].nodeValue;
                            let phase = val.getElementsByTagName("camunda:inputParameter")[0].innerHTML;
                            let description = val.getElementsByTagName("camunda:inputParameter")[1].innerHTML;
                            let assignee = val.attributes["camunda:assignee"].nodeValue;

                            //console.log(phase+" => "+description);

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: "{{ route('writeAllTasksToDatabase')}}",
                                type: "POST",
                                data: {xml_task_name: xmlName, xml_task_id: response.task.xml_task_id, definitionId: response.process.xml_definition_id, instanceId: response.process.xml_instance_id , process_name: processName, phase: phase, description: description, assignee: assignee, response: response},
                                success: function (response) {}
                            });

                        });
                    });

                    $('#buttons-div').html("<div class='text-center' style='margin-top: 10px'><i class=\"fa fa-spinner fa-pulse fa-3x fa-fw\"></i><p>{{ trans('translation.general.process.is-starting') }}</p></div>");

                    setTimeout(function () {
                        $('#exampleModal').modal('hide');
                        alert("{{ trans('translation.general.new-process-created') }}");
                        window.location = "/admin/task/"+ processId +"/"+ response.process.xml_instance_id+"/index";
                    }, 3000)
                }
            });
        }
    }
</script>
@endsection
