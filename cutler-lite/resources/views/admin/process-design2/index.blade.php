@extends('admin.parent')

@section('title', trans('translation.general.process-design.process-design'))

@section('css')
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="//cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
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
                    <h1>{{ trans('translation.general.process-design.process-design') }}</h1>
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
                    <span class="active">{{ trans('translation.general.process-design.process-design') }}</span>
                </li>
            </ul>


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
                    @if(Session::has('error_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('error_message') !!}
                        </div>
                    @endif
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-users"></i>
                                {{ trans('translation.general.process-design.process-design') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-3" id="process_div">
                                    <label>{{ trans('translation.general.process-design.processes') }}</label>
                                    {!! Form::select('process_id', $processList, $processId, ['id' => 'process_id', 'class' => 'form-control', 'onchange' => 'getTasks()']) !!}
                                </div>
                                <div class="col-md-3" id="process_div">
                                    <label>{{ trans('translation.general.process-design.policies') }}</label>
                                    {!! Form::select('policy_id', $policyList, null, ['id' => 'policy_id', 'class' => 'form-control', 'onchange' => 'assignProcessToPolicy()']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet box green hidden" id="selected_widgets_table_div">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-pie-chart"></i>
                                {{ trans('translation.general.process-design.selected-widgets') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th> {{ trans('translation.general.process-design.dashboard-name') }} </th>
                                        <th> {{ trans('translation.general.process-design.widget-title') }} </th>
                                        <th> {{ trans('translation.general.process-design.type') }} </th>
                                        <th> {{ trans('translation.general.process-design.widget') }} </th>
                                        <th> {{ trans('translation.general.process-design.actions') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody id="selected_widgets_data_table_div">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="portlet box green hidden" id="user_details_table_div">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>
                                {{ trans('translation.general.process-design.policy-creator') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th> {{ trans('translation.general.process-design.user.name') }} </th>
                                        <th> {{ trans('translation.general.process-design.user.surname') }} </th>
                                        <th> {{ trans('translation.general.process-design.user.email') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody id="user_details_data_table_div">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="portlet box blue hidden" id="all_widgets_table_div">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-pie-chart"></i>
                                {{ trans('translation.general.process-design.all-widgets') }}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table id="widgetsTable" class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th> {{ trans('translation.general.process-design.dashboard-name') }} </th>
                                        <th> {{ trans('translation.general.process-design.widget-title') }} </th>
                                        <th> {{ trans('translation.general.process-design.type') }} </th>
                                        <th> {{ trans('translation.general.process-design.actions') }} </th>
                                        <th> {{ trans('translation.general.process-design.widget') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->

            <div id="task-and-widget-dashboards-div"></div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection

@section('js')
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script>
        function getTasks() {
            let processId = $('#process_id option:selected').val();
            let processKey = processId.split(':')[0];
            let processListWithDetail = JSON.parse('{!! json_encode($processListWithId, true) !!}');

            let filteredProcess = processListWithDetail.filter(function (value) {
                return value.key === processKey;
            })[0];

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // let $tasksTableBody = $('#task_div').find('tbody');
            $.ajax({
                url: "{{ route('process-design2.tasks') }}",
                type: "GET",
                timeout: 10000,
                data: {
                    process_id: processId,
                    process_key: processKey,
                    filteredProcessName: filteredProcess.name,
                    filteredProcessId: filteredProcess.id
                },
                success: function (tasks) {
                    $('#task-and-widget-dashboards-div').html(tasks);
                    // let row = '';
                    // tasks.forEach(function (task) {
                    //     row += '<tr>';
                    //     row += '<td>' + task.name + '</td>';
                    //     row += '<td>' + task.widgets_count + '</td>';
                    //     row += '<td><a href="' + task.detail_url + '?processKey=' + processKey + '&taskName=' + task.name + '&processName=' + filteredProcess.name + '&processId=' + filteredProcess.id + '" class="btn btn-success">DETAILS</a></td>';
                    //     row += '</tr>';
                    // });
                    // $tasksTableBody.append(row);
                    // $('#task_div').removeClass('hidden');
                    $('.processName').html($('#process_id option:selected').text());
                    getSelectedPolicy(processId);
                }
            });
        }

        function getSelectedPolicy(processId) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('process-design2.getSelectedPolicy') }}",
                type: "POST",
                timeout: 10000,
                data: {processId: processId},
                success: function (policyId) {
                    $('#policy_id').val(policyId);
                    if (policyId != 0) {
                        $('.policyName').html($('#policy_id option:selected').text());
                    }
                }
            });
        }

        function showProcess() {
            $('#process_div').removeClass('hidden');
        }

        @if(!is_null($processId))
        getTasks()

        @endif



        function assignProcessToPolicy() {
            var process_id = $('#process_id option:selected').val();
            var process_name = $('#process_id option:selected').text();
            var policy_id = $('#policy_id option:selected').val();
            var policy_name = $('#policy_id option:selected').text();
            $('.policyName').html(policy_name);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('process-design2.assignProcessToPolicy') }}",
                type: "POST",
                timeout: 10000,
                data: {
                    process_id: process_id,
                    process_name: process_name,
                    policy_id: policy_id,
                    policy_name: policy_name
                },
                success: function (response) {
                    if (response == 1) {
                        alert("{{ trans('translation.general.assign-completed') }}");
                    }
                }
            });
        }
    </script>
@endsection
