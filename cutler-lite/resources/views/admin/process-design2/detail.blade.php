@extends('admin.parent')

@section('title', trans('translation.general.task-show.widgets'))

@section('css')
    <link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="//cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <style>
        .selected {
            background-color: #ffccc8;
        }
    </style>
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
                    <h1>{{ trans('translation.general.widget-select-process') }}</h1>
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
                    <span class="active">{{ trans('translation.general.widget-select-process') }}</span>
                </li>
            </ul>
            <!-- END PAGE BREADCRUMB -->
            <hr>
            <h4><span
                    style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.process-name') }}</span>
                : {{ $processName }}</h4>
            <h4><span
                    style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.task-name') }}</span>
                : {{ $taskName }}</h4>
            <hr>
            <!--<a href="" class="btn btn-primary">Back To Process Design</a>-->

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif

                    <div class="portlet box blue" id="all_widgets_table_div">
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
                                        <th> Selected</th>
                                        <th> {{ trans('translation.general.process-design.actions') }} </th>
                                        <th> {{ trans('translation.general.process-design.widget') }} </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $addedWidgets = array();
                                    @endphp
                                    @foreach($widgets as $widget)
                                        @if(!array_key_exists($widget['id'], $addedWidgets))
                                            @php
                                                $addedWidgets[$widget['id']] = true;
                                            @endphp

                                            {{--                                            @if($widget['type']=='dashboard')--}}
                                            {{--                                                @continue--}}
                                            {{--                                            @endif--}}

                                            <tr id="tr-{{ $widget['id'] }}"
                                                @if(array_search($widget['id'], array_column($widgetObjects, 'id')) !== false) class="selected" @endif>
                                                @if($widget['type']=='dashboard')
                                                    <input type="hidden" id="wtype-{{ $widget['id'] }}" value="1"/>
                                                @else
                                                    <input type="hidden" id="wtype-{{ $widget['id'] }}" value="2"/>
                                                @endif
                                                <td>{{ $widget['name'] }}</td>
                                                <td>{{ $widget['title'] }}</td>
                                                <td>{{ $widget['type'] }}</td>
                                                <td>
                                                    @if(array_search($widget['id'], array_column($widgetObjects, 'id')) !== false)
                                                        Selected @endif
                                                </td>
                                                <td>
                                                    <button type="button" data-widget-id="{{ $widget['id'] }}"
                                                            class="btn btn-success select-widget-button wbid-{{ $widget['id'] }} wbtype-{{ $widget['type']=='dashboard'?'1':'2' }}"
                                                            id="{{ $widget['id'] }}"
                                                            onclick="selectClick('{{ $widget['id'] }}')">
                                                        <i class="fa fa-check-square-o"></i> {{ trans('translation.general.select') }}
                                                    </button>
                                                </td>
                                                <td>
                                                    @if($widget['type'] == "dashboard")
                                                        <button type="button"
                                                                onclick="dashboardModal('{{ $widget['id'] }}')"
                                                                class="btn btn-primary">
                                                            {{ trans('translation.general.task-show.widget-preview') }}
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                                onclick="widgetModal('{{ $widget['id'] }}')"
                                                                class="btn btn-primary">
                                                            {{ trans('translation.general.task-show.widget-preview') }}
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="page-toolbar">
                                    <form action="{{ route('process-design2.add-widget-to-task') }}" method="post"
                                          id="add-widget-form">
                                        @csrf
                                        <input type="hidden" name="process_id" value="{{ $processId }}">
                                        <input type="hidden" name="process_name" value="{{ $processName }}">
                                        <input type="hidden" name="task_name" value="{{ $taskName }}">
                                        <input type="hidden" name="process_key" value="{{ $processKey }}">
                                        <input type="hidden" name="task_key" value="{{ $taskKey }}">
                                        <div class="col-md-12" style="margin-top:15px;">
                                            <label
                                                class=" mt-5">{{ trans('translation.general.task-show.date-filter') }}</label>
                                            <div class="mt-radio-inline">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label
                                                                for="start">{{ trans('translation.general.task.start-date') }}</label>
                                                            {!! Form::date('start_date', $taskDateFilter->start_date ?? null, ['class' => 'form-control']) !!}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label
                                                                for="start">{{ trans('translation.general.task.end-date') }}</label>
                                                            {!! Form::date('end_date', $taskDateFilter->end_date ?? null, ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="margin-top: 23px">
                                                    <div class="row">
                                                        <label class="mt-radio" style="margin-top: 7px;">
                                                            <input type="radio" name="last_selection" value="7d"
                                                                   onclick="go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/7b51b680-91f1-11ea-b572-2f4c699ae94d?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-7d%2Cto%3Anow))')"
                                                                   @if(!is_null($taskDateFilter))
                                                                   @if($taskDateFilter->last_selection == '7d') checked @endif
                                                                @endif
                                                            >
                                                            {{ trans('translation.general.task-show.last-seven') }}
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio" style="margin-top: 7px;">
                                                            <input type="radio" name="last_selection" value="1M"
                                                                   onclick="go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/7b51b680-91f1-11ea-b572-2f4c699ae94d?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-1M%2Cto%3Anow))')"
                                                                   @if(!is_null($taskDateFilter))
                                                                   @if($taskDateFilter->last_selection == '1M') checked @endif
                                                                @endif
                                                            >
                                                            {{ trans('translation.general.task-show.last-month') }}
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio" style="margin-top: 7px;">
                                                            <input type="radio" name="last_selection" value="1y"
                                                                   onclick="go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/7b51b680-91f1-11ea-b572-2f4c699ae94d?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-1y%2Cto%3Anow))')"
                                                                   @if(!is_null($taskDateFilter))
                                                                   @if($taskDateFilter->last_selection == '1y') checked @endif
                                                                @endif
                                                            >
                                                            {{ trans('translation.general.task-show.last-1-year') }}
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio" style="margin-top: 7px;">
                                                            <input type="radio" name="last_selection" value="3y"
                                                                   onclick="go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/7b51b680-91f1-11ea-b572-2f4c699ae94d?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(from%3Anow-3y%2Cto%3Anow))')"
                                                                   @if(!is_null($taskDateFilter))
                                                                   @if($taskDateFilter->last_selection == '3y') checked @endif
                                                                @endif
                                                            >
                                                            {{ trans('translation.general.task-show.last-year') }}
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary add-widgets" id="saveBtn"
                                                onclick="saveBtnClick()"> {{ trans('translation.general.save') }} <span
                                                class="hidden">(0)</span>
                                        </button>
                                        @if(count($widgetObjects)>0)
                                            @foreach($widgetObjects as $widget)
                                                @if(strpos($widget['json'], 'dashboard'))
                                                    <input type="hidden" id="widget-{{ $widget['id'] }}"
                                                           name="widget"
                                                           value="{{ $widget['json'] }}">
                                                @else
                                                    <input type="hidden" id="widget-{{ $widget['id'] }}"
                                                           name="widgets[]"
                                                           value="{{ $widget['json'] }}">
                                                @endif
                                            @endforeach
                                        @endif
                                    </form>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('#widgetsTable').DataTable({
                pageLength: 10,
                "order": [[3, "desc"]],
                "columnDefs": [
                    {
                        "targets": [3],
                        "visible": false,
                        "searchable": false
                    }
                ],
                "drawCallback": function (settings) {
                    dashboardStateControl();
                },
                "initComplete": function (settings, json) {
                    dashboardStateControl();
                }
            });
        })
    </script>
    <script>
        $(function () {
            minDateFilter = "";
            maxDateFilter = "";

            $("#daterange").daterangepicker({
                timePicker: true,
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'YYYY-MM-DDThh:mm'
                }
            });

            $(".applyBtn").click(function () {
                $('.dateview').css('display', 'block');
                var inputStartVal = $("input[name='daterangepicker_start']").val();
                var inputEndVal = $("input[name='daterangepicker_end']").val();
                $('.StartDateVal').html(inputStartVal);
                $('.EndDateVal').html(inputEndVal);
                var time_url = "from:'" + inputStartVal + "T00:00:00.000Z',to:'" + inputEndVal + "T00:00:00.000Z'";
                //go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/722b74f0-b882-11e8-a6d9-e546fe2bba5f?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A('+time_url+'))');
                go('{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/7b51b680-91f1-11ea-b572-2f4c699ae94d?embed=true&_g=(refreshInterval%3A(pause%3A!t%2Cvalue%3A0)%2Ctime%3A(' + time_url + '))');
            });

        });
    </script>
    <script>
        var btnstatus = 0;


        @if(count($widgetObjects)>0)
        var lastselectedwidget = '{{ $widgetObjects[0]['id'] }}';
        var widgetcount = {{ count($widgetObjects) }};
        @if(strpos($widgetObjects[0]['json'], '"type":"dashboard"'))
        var lastselectedwidgettype = 1;
        @else
        var lastselectedwidgettype = 2;
        @endif
        @else
        var lastselectedwidget = 0;
        var lastselectedwidgettype = 0;
        var widgetcount = 0;
        //dashboardStateControl();
        @endif

        function widgetModal(widgetId) {
            var modal = '';
            modal += '<div class="modal fade" id="widget-modal' + widgetId + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            modal += '  <div class="modal-dialog" role="document">';
            modal += '    <div class="modal-content">';
            modal += '      <div class="modal-header">';
            modal += '        <h5 class="modal-title" id="exampleModalLabel">{{ trans('translation.general.task-show.widget-preview') }}</h5>';
            modal += '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            modal += '          <span aria-hidden="true">&times;</span>';
            modal += '        </button>';
            modal += '      </div>';
            modal += '      <div class="modal-body">';
            modal += '<iframe class="widget" style="width: 100%; height: 570px" src="{{ $settings->kibana_preview_url }}/app/kibana#/visualize/edit/' + widgetId + '?_g=(filters:!(),refreshInterval:(pause:!t,value:0))&_a=(description:\'\',filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:\'\'),timeRestore:!f,viewMode:view)"></iframe>';
            //modal += '<iframe class="widget" style="width: 570px; height: 570px" src="{{ $settings->kibana_preview_url }}/app/kibana#/visualize/edit/' + widgetId + '?embed=true&_g=()"></iframe>';
            modal += '      </div>';
            modal += '      <div class="modal-footer">';
            modal += '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
            modal += '      </div>';
            modal += '    </div>';
            modal += '  </div>';
            modal += '</div>';
            $("#previewModal").html(modal);
            $("#widget-modal" + widgetId).modal('show');
        }

        function dashboardModal(widgetId) {
            var modal = '';
            modal += '<div class="modal fade" id="widget-modal' + widgetId + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            modal += '  <div class="modal-dialog modal-lg" style="width: 90%" role="document">';
            modal += '    <div class="modal-content">';
            modal += '      <div class="modal-header">';
            modal += '        <h5 class="modal-title" id="exampleModalLabel">{{ trans('translation.general.task-show.widget-preview') }}</h5>';
            modal += '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            modal += '          <span aria-hidden="true">&times;</span>';
            modal += '        </button>';
            modal += '      </div>';
            modal += '      <div class="modal-body">';
            modal += '<iframe class="widget" style="width: 100%; height: 570px" src="{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/' + widgetId + '?_g=(filters:!(),refreshInterval:(pause:!t,value:0))&_a=(description:\'\',filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:\'\'),timeRestore:!f,viewMode:view)"></iframe>';
            //modal += '<iframe class="widget" style="width: 100%; height: 570px" src="{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/' + widgetId + '?embed=true&_g=()"></iframe>';
            modal += '      </div>';
            modal += '      <div class="modal-footer">';
            modal += '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
            modal += '      </div>';
            modal += '    </div>';
            modal += '  </div>';
            modal += '</div>';
            $("#previewModal").html(modal);
            $("#widget-modal" + widgetId).modal('show');
        }

        /*
        $('#widgetsTable').on('click', 'tbody tr', function () {
            $(this).toggleClass('selected');
            let $addWidgetButton = $('.add-widgets span');
            let countWidget = $('#widgetsTable tr.selected').length;
            let $status = $(this).hasClass('selected');
            let $widgetId = $(this).find('button.select-widget-button').data('widget-id');
            let $rowData = $(this).find('td').toArray();
            let widget = {id: '', name: '', title: '', type: ''};
            widget.id = $widgetId;
            widget.name = $rowData[0]['innerText'];
            widget.title = $rowData[1]['innerText'];
            widget.type = $rowData[2]['innerText'];

            if ($status) {
                $('#add-widget-form').append('<input type="hidden" id="widget-' + $widgetId + '" name="widgets[]" value="' + encodeURIComponent(JSON.stringify(widget)) + '">');
            } else {
                $('input#widget-' + $widgetId + '').remove();
            }

            if (countWidget > 0) {
                $addWidgetButton.removeClass('hidden').text('(' + countWidget + ')');
            } else {
                $addWidgetButton.addClass('hidden');
            }
        });
        */

        function selectClick(widgetId) {
            $("#tr-" + widgetId).toggleClass('selected');
            let $addWidgetButton = $('.add-widgets span');
            let countWidget = $('#widgetsTable tr.selected').length;
            let $status = $("#tr-" + widgetId).hasClass('selected');
            //let $widgetId = $(this).find('button.select-widget-button').data('widget-id');
            let $widgetId = widgetId;
            let $rowData = $("#tr-" + widgetId).find('td').toArray();
            let widget = {id: '', name: '', title: '', type: ''};
            widget.id = $widgetId;
            widget.name = $rowData[0]['innerText'];
            widget.title = $rowData[1]['innerText'];
            widget.type = $rowData[2]['innerText'];

            window.lastselectedwidget = widgetId;
            window.lastselectedwidgettype = $("#wtype-" + widgetId).val();

            if ($status) {
                if (window.lastselectedwidgettype == 2) {
                    $('#add-widget-form').append('<input type="hidden" id="widget-' + $widgetId + '" name="widgets[]" value="' + encodeURIComponent(JSON.stringify(widget)) + '">');
                } else {
                    $('#add-widget-form').append('<input type="hidden" id="widget-' + $widgetId + '" name="widget" value="' + encodeURIComponent(JSON.stringify(widget)) + '">');
                }
                window.widgetcount++;
            } else {
                $('input#widget-' + $widgetId + '').remove();
                window.widgetcount--;
            }

            if (window.widgetcount > 0) {
                $('.add-widgets').removeClass('disabled').attr('disabled', false);
                $addWidgetButton.removeClass('hidden').text('(' + window.widgetcount + ')');
            } else {
                $('.add-widgets').addClass('disabled').attr('disabled', true);
                $addWidgetButton.addClass('hidden');
            }

            dashboardStateControl();
        }

        $('#widgetsTable').on('page.dt', function () {
            //dashboardStateControl();
        });

        function dashboardStateControl() {
            var widgetId = window.lastselectedwidget;
            if (widgetId != 0) {
                var wtype = window.lastselectedwidgettype;
                console.log(wtype);
                if (wtype == 1) {
                    $(".wbtype-1").attr('disabled', true);
                    $(".wbtype-2").attr('disabled', true);
                    $(".wbid-" + widgetId).attr('disabled', false);
                } else {
                    $(".wbtype-1").attr('disabled', true);
                }
            }

            if (window.widgetcount == 0) {
                $(".wbtype-1").attr('disabled', false);
                $(".wbtype-2").attr('disabled', false);
            }
        }

        function saveBtnClick() {
            if (window.btnstatus === 0) {
                $("#saveBtn").html('<i class="fa fa-spinner fa-spin"></i>' + $("#saveBtn").text());
                window.btnstatus = 1;
                $("#saveBtn").attr('disabled', true);
                document.getElementById('add-widget-form').submit();
            }
        }

        $(document).ready(function () {
            let $addWidgetButton = $('.add-widgets span');

            if (window.widgetcount > 0) {
                $addWidgetButton.removeClass('hidden').text('(' + window.widgetcount + ')');
            } else {
                $('.add-widgets').addClass('disabled').attr('disabled', true);
                $addWidgetButton.addClass('hidden');
            }
        });
    </script>
@endsection
