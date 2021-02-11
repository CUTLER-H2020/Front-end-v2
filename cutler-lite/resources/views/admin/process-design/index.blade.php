@extends('admin.parent')

@section('title', trans('translation.general.process-design.process-design'))

@section('css')
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="//cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
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


{{--<p>"Process Design" sayfasında bulunan Tasklar "Process" sayfasında bulunan "start new proses" butonuna tıklamadan gelmiyordu</p>--}}
{{--<p>artık proses dizayn sayfası bağımsız bir sayfa olacak,</p>--}}
{{--<p>yani içeride bir task var ise start new proses demeden taskları getireceğiz.</p>--}}
{{--<p>Sonra xmlden veriyi parse edip Multible Select içine yerleştireceğiz.</p>--}}

{{--<p>Tasklar task id ye göre değil aşağıda "yeni yöntem" yazan sorgudan getirilecektir.</p>--}}
{{--<p><strong>Eski Yöntem :</strong> http://92.45.59.250:8004/engine-rest/process-definition/task-id-ile/xml (Task id örneği : "model_1:1:df7bd150-7fa0-11ea-8bc1-0a0027000002")</p>--}}
{{--<p><strong>Yeni Yöntem :</strong> http://92.45.59.250:8004/engine-rest/process-definition/key/key-id-ile/xml (Key id örneği : "model_1")</p>--}}



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
                                <i class="fa fa-users"></i>
                                {!! $page['title'] !!}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>{{ trans('translation.general.process-design.policies') }}</label>
                                    {!! Form::select('policy_id', $policyList, null, ['id' => 'policy', 'class' => 'form-control', 'onchange' => 'showProcess()']) !!}
                                </div>
                                <div class="col-md-3 hidden" id="process_div">
                                    <label>{{ trans('translation.general.process-design.processes') }}</label>
                                    {!! Form::select('process_id', $processList, null, ['id' => 'process', 'class' => 'form-control','onchange' => 'getTasks()']) !!}
                                </div>
                                <div class="col-md-3 hidden" id="task_div">
                                    <label>{{ trans('translation.general.process-design.tasks') }}</label>
                                    {!! Form::select('task_id', [], null, ['id' => 'task', 'class' => 'form-control', 'onchange' => 'getWidgets()']) !!}
                                </div>
                                <div class="col-md-3 hidden" id="button_div">
                                    <button id="submitButton" type="button" class="btn btn-success" style="margin-top: 24px">{{ trans('translation.general.process-design.add') }}</button>
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
                                <table  class="table" style="width:100%">
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
                                <table  class="table" style="width:100%">
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
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <div id="previewModal"></div>
@endsection

@section('js')
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
    function getTasks() {
        var process_name = $('#process option:selected').text();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('getTasks') }}",
            type: "POST",
            timeout: 10000,
            data: {process_name: process_name},
            success: function (response) {
                $('#task').html(response);
                $('#task_div').removeClass('hidden');
            }
        });
    }

    function showProcess() {
        $('#process_div').removeClass('hidden');
    }

    function getWidgets() {
        var typeOfPolicy = "antalya";
        var xmlhtml = new XMLHttpRequest();
        var url = "{{ $settings->kibana_preview_url }}/" + typeOfPolicy + "/";
        xmlhtml.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200){
                var widgetsJson = this.responseText;
                var parsedWidgetsJson = JSON.parse(widgetsJson);
                var size = parsedWidgetsJson.length;
                widgets = [];
                for(i = 0; i < size; i++){
                    widget = [
                        parsedWidgetsJson[i].name,
                        parsedWidgetsJson[i].title,
                        parsedWidgetsJson[i].type,
                        '<button type="button" id="' + parsedWidgetsJson[i].id + '" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{ trans('translation.general.select') }}</button>',
                        '<button type="button" onclick="previewModal('+"'"+ parsedWidgetsJson[i].id +"'"+')" class="btn btn-primary"> Wıdget Prevıew</button>',
                        parsedWidgetsJson[i].id
                    ];
                    widgets.push(widget);
                }
                getUserDetails();
                pushWidgetsDataTable(widgets);
            }
        };
        xmlhtml.open("GET", url, true);
        xmlhtml.send();
    }

    function pushWidgetsDataTable(result) {
        $.fn.dataTable.ext.errMode = 'none';
        var table = $('#widgetsTable').DataTable({
           "data" : result,
        });

        $('#all_widgets_table_div').removeClass('hidden');
        $('#button_div').removeClass('hidden');

        $('#widgetsTable').on('click', 'tbody tr', function () {
            $(this).toggleClass('selected');
        });

        getSelectedWidgets();

        $('#submitButton').click(function () {
            var rowData = table.rows('.selected').data().toArray();
            selectedPolicyID = $("#policy option:selected")[0].value;
            selectedPolicy = $("#policy option:selected").text();
            selectedProcessID = $("#process option:selected")[0].value;
            selectedProcess = $("#process option:selected").text();
            selectedTaskID = $("#task option:selected")[0].value;
            selectedTask = $("#task option:selected").text();

            for (i = 0; i < rowData.length; i++){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('saveWidget') }}",
                    type: "POST",
                    timeout: 10000,
                    data: {
                        policy_id: selectedPolicyID,
                        policy_name: selectedPolicy,
                        process_name: selectedProcess,
                        process_id: selectedProcessID,
                        task_name: selectedTask,
                        task_id: selectedTaskID,
                        widget_name: rowData[i][0],
                        widget_title: rowData[i][1],
                        widget_type: rowData[i][2],
                        widget_id: rowData[i][5],
                    },
                    success: function (response) {

                    }
                });
            }
            alert("All widgets send");
            location.reload();
        })

    }

    function getSelectedWidgets() {
        var selectedPolicyID = $("#policy option:selected")[0].value;
        var selectedProcessID = $("#process option:selected")[0].value;
        var selectedTaskID = $("#task option:selected")[0].value;
        var selectedTask = $("#task option:selected").text();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('getSelectedWidgets') }}",
            type: "POST",
            timeout: 10000,
            data: {selectedPolicyID: selectedPolicyID, selectedProcessID:selectedProcessID, selectedTaskID:selectedTaskID, selectedTask:selectedTask},
            success: function (response) {
                $('#selected_widgets_table_div').removeClass('hidden');
                $('#selected_widgets_data_table_div').html(response);
            }
        });
    }

    function deleteWidget(widgetId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('deleteWidget') }}",
            type: "POST",
            timeout: 10000,
            data: {widgetId: widgetId},
            success: function (response) {
                if(response == 1){
                    getSelectedWidgets();
                }
            }
        });
    }

    function previewModal(widgetId) {
        var modal = '';
        modal += '<div class="modal fade" id="widget-modal'+ widgetId +'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        modal += '  <div class="modal-dialog" role="document">';
        modal += '    <div class="modal-content">';
        modal += '      <div class="modal-header">';
        modal += '        <h5 class="modal-title" id="exampleModalLabel">Widget Preview</h5>';
        modal += '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        modal += '          <span aria-hidden="true">&times;</span>';
        modal += '        </button>';
        modal += '      </div>';
        modal += '      <div class="modal-body">';
        modal += '<iframe class="widget" style="width: 570px; height: 570px" src="{{ $settings->kibana_preview_url }}/app/kibana#/visualize/edit/' + widgetId + '?embed=true&_g=()"></iframe>';
        modal += '      </div>';
        modal += '      <div class="modal-footer">';
        modal += '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
        modal += '      </div>';
        modal += '    </div>';
        modal += '  </div>';
        modal += '</div>';
        $("#previewModal").html(modal);
        $("#widget-modal"+ widgetId).modal('show');
    }

    function getUserDetails() {
        selectedPolicyID = $("#policy option:selected")[0].value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('getUser') }}",
            type: "POST",
            timeout: 10000,
            data: {selectedPolicyID: selectedPolicyID},
            success: function (response) {
                $('#user_details_data_table_div').html(response);
                $('#user_details_table_div').removeClass('hidden');
            }
        });
    }

</script>
@endsection
