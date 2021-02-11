<!-- END PAGE BREADCRUMB -->
<hr>
<h4><span
        style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.process-name') }}</span>
    : <span class="processName"></span></h4>
<h4><span
        style="width:125px; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.policy-name') }}</span>
    : <span class="policyName"></span></h4>
<hr>
<!-- BEGIN PAGE BASE CONTENT -->
<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">{{ trans('translation.general.task-list') }}</div>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
            <table id="data1" class="display dt-responsive nowrap table table-striped table-bordered">
                <thead>
                <tr>
                    <th width="10%">{{ trans('translation.general.tasks.task-name') }}</th>
                    <th width="5%" class="text-center">{{ trans('translation.general.tasks.widget-count') }}</th>
                    <th width="30%">{{ trans('translation.general.tasks.description') }}</th>
                    <th width="10%">{{ trans('translation.general.tasks.assignee') }}</th>
                    <th width="5%">{{ trans('translation.general.tasks.candidate-users') }}</th>
                    <th width="5%">{{ trans('translation.general.tasks.candidate-groups') }}</th>
                    <th width="15%">{{ trans('translation.general.tasks.details') }}</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < count($tasksReturn); $i++)
                    <tr @if($tasksReturn[$i]['widgets_count'] == 0) style="background-color: #ffccc8;" @endif >
                        <td>{{ $tasksReturn[$i]['name'] }}</td>
                        <td class="text-center">{{ $tasksReturn[$i]['widgets_count'] }} @if(!is_null($tasksReturn[$i]['widgetPreview'])){{ $tasksReturn[$i]['widgetPreview']->widget_type == 'dashboard' ? '(D)' : '' }}@endif</td>
                        <td>{{ $tasksReturn[$i]['description'] }}</td>
                        <td>{{ $tasksReturn[$i]['assignee'] }}</td>
                        <td>{{ $tasksReturn[$i]['candidateUsers'] }}</td>
                        <td>{{ $tasksReturn[$i]['candidateGroups'] }}</td>
                        <td>
                            <div class="alert alert-warning" role="alert">
                                Design can be done in paid version
                            </div>
{{--                            <a href="javascript:designBtnClick('{{ $tasksReturn[$i]['detail_url']. '?processKey='.$tasksReturn[$i]['processKey'].'&taskName='. $tasksReturn[$i]['name'] .'&processName='.$tasksReturn[$i]['filteredProcessName'].'&processId='. $tasksReturn[$i]['filteredProcessId'] }}', {{ $i }})"--}}
{{--                               class="btn btn-success designBtn" id="designBtn-{{ $i }}"--}}
{{--                               style="text-transform: none;">{{ trans('translation.general.tasks.design') }}</a>--}}
{{--                            @if($tasksReturn[$i]['widgets_count'] > 0)--}}
{{--                                <button--}}
{{--                                    onclick="previewModal('{{ $tasksReturn[$i]['widgetPreview']['dashboard_id'] }}', '{{ $tasksReturn[$i]['name'] }}', '{{ $tasksReturn[$i]['filteredProcessId'] }}')"--}}
{{--                                    class="btn btn-primary"--}}
{{--                                    style="text-transform: none">{{ trans('translation.general.process-design-preview') }}--}}
{{--                                </button>--}}
{{--                            @endif--}}

                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if($processImage)
            <div class="alert alert-info">{{ trans('translation.general.tasks.change-image') }}</div>
            <div style="height: 250px; overflow:auto;"><img src="{{ asset('uploads/process/'.$processImage->image) }}"
                                                            style="width:100%; height: auto; margin-bottom: 25px;"/>
            </div>

        @else
            <div class="alert alert-warning">{{ trans('translation.general.tasks.model-image') }}</div>
        @endif
        <hr>
        <form action="{{ route('process-design2.processImageUpload') }}" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="process_id" value="{{ $processId }}"/>
            <div class="alert alert-danger print-error-msg" style="display:none;">
                <ul></ul>
            </div>
            <input type="file" class="btn btn-success" name="image" style="margin-bottom: 15px; float:left;"
                   accept="image/*"/>
            <button type="submit" class="btn btn-danger upload-image"
                    style="float:left; margin-left:5px;">{{ trans('translation.general.save') }}</button>
        </form>
        <div class="col-md-12">
            <hr/>
        </div>
    </div>
</div>


<div class="portlet box blue" style="margin-top:5px;">
    <div class="portlet-title">
        <div class="caption">{{ trans('translation.general.tasks.dashboard-widget') }}</div>
    </div>
    <div class="portlet-body">
        <div class="table-responsive">
            <div class="row">
                @php
                    $widgetCountTemp = 0;
                @endphp
                @for($i = 0; $i < count($tasksReturn); $i++)
                    @if(!is_null($tasksReturn[$i]['widgetPreview']))
                        <div class="col-md-12">
                            <div class="mt-element-ribbon bg-grey-steel">
                                <div
                                    class="ribbon ribbon-color-default uppercase">{{ $tasksReturn[$i]['name'] }}</div>
                                <p class="ribbon-content" style="padding: 7px">
                                    @php
                                        $taskDateFilter = \App\Models\ProcessDesignDateFilter::whereTaskName($tasksReturn[$i]['widgetPreview']['task_name'])->whereXmlProcessId($tasksReturn[$i]['widgetPreview']['xml_process_id'])->first();
                                        if($taskDateFilter){
                                            $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$tasksReturn[$i]['widgetPreview']['dashboard_id'];

                                            if (is_null($taskDateFilter->last_selection)) {
                                                //$time = "from:'" . $taskDateFilter->start_date . "T00:00:00.000Z',to:'" . $taskDateFilter->end_date . "T23:59:59.000Z'";
                                                if($taskDateFilter->start_date!=''){
                                                    $time = "from:'" . $taskDateFilter->start_date . "',to:'" . $taskDateFilter->end_date . "'";
                                                    $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$tasksReturn[$i]['widgetPreview']['dashboard_id']."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(".$time."))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                                } else {
                                                    $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$tasksReturn[$i]['widgetPreview']['dashboard_id'];
                                                }
                                            } else {
                                                switch ($taskDateFilter->last_selection) {
                                                    case "7d":
                                                        $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$tasksReturn[$i]['widgetPreview']['dashboard_id']."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(from%3Anow-7d%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                                    break;
                                                    case "1M":
                                                        $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$tasksReturn[$i]['widgetPreview']['dashboard_id']."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(from%3Anow-1M%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                                        break;
                                                    case "1y":
                                                        $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$tasksReturn[$i]['widgetPreview']['dashboard_id']."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(from%3Anow-1y%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                                    break;
                                                    case "3y":
                                                        $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$tasksReturn[$i]['widgetPreview']['dashboard_id']."?_g=(filters:!(),refreshInterval:(pause:!f,value:900000),time:(from%3Anow-3y%2Cto%3Anow))&_a=(description:Dashboard,filters:!(),fullScreenMode:!f,options:(hidePanelTitles:!f,useMargins:!t),query:(language:kuery,query:''),timeRestore:!t,viewMode:view)";
                                                    break;
                                                }
                                            }
                                        } else {
                                            $iframeUrl = $settings->kibana_preview_url."/app/kibana#/dashboard/".$tasksReturn[$i]['widgetPreview']['dashboard_id'];
                                        }
                                    @endphp
                                    <iframe class="widget" scrolling="yes"
                                            style="width:100%; @if($tasksReturn[$i]['widgetPreview']['widget_type'] != "dashboard") height:{{ ceil($tasksReturn[$i]['widgets_count']/2)*300 }}px @else height:500px @endif"
                                            id="w4"
                                            frameborder="0" scrolling="yes"
                                            src="{{ $iframeUrl }}"></iframe>

                                    <?php
                                    /*
                                    <iframe class="widget" scrolling="yes"
                                            style="width:100%; @if($tasksReturn[$i]['widgetPreview']['widget_type'] != "dashboard") height:{{ ceil($tasksReturn[$i]['widgets_count']/2)*300 }}px @else height:500px @endif"
                                            id="w4"
                                            frameborder="0" scrolling="yes"
                                            src="{{ $settings->kibana_preview_url }}/app/kibana#/dashboard/{{ $tasksReturn[$i]['widgetPreview']['dashboard_id'] }}?embed=true&_g=()"></iframe>
                                    */
                                    ?>
                                </p>
                            </div>
                        </div>
                        @php
                            $widgetCountTemp++;
                        @endphp
                    @endif
                @endfor
                @if($widgetCountTemp==0)
                    <div class="text-center">
                        {{ trans('translation.general.tasks.no-widget') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="previewModal"></div>

<script src="http://malsup.github.com/jquery.form.js"></script>

<script type="text/javascript">
    $("body").on("click", ".upload-image", function (e) {
        $(this).parents("form").ajaxForm(options);
    });
    window.btnstatus = 0;

    var options = {
        complete: function (response) {
            if ($.isEmptyObject(response.responseJSON.errors)) {
                //alert('Resim başarıyla yüklendi.');
                getTasks();
            } else {
                printErrorMsg(response.responseJSON.errors);
            }
        }
    };

    function printErrorMsg(msg) {
        //alert("Resim yüklenemedi, tekrar deneyin.");
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function (key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

    function designBtnClick(url, id) {
        if (window.btnstatus === 0) {
            $("#designBtn-" + id).html('<i class="fa fa-spinner fa-spin"></i> Design');
            window.btnstatus = 1;
            $(".designBtn").attr('disabled', true);
            window.location = url;
        }
    }


    $(document).ready(function () {
        $('#data').DataTable({

            dom: 'Bfrtip',
            pageLength: 10,
            ordering: true,
            pagingType: "numbers",
            columnDefs: [
                {width: "20%"}
            ]
        });
    });

    function previewModal(dashboardId, taskName, processId) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('process-design2.dashboardPreviewModel') }}",
            type: "POST",
            timeout: 10000,
            data: {
                dashboard_id: dashboardId,
                task_name: taskName,
                process_id: processId
            },
            success: function (response) {
                $("#previewModal").html(response);
                $("#widget-modal" + dashboardId).modal('show');
            }
        });

        {{--var modal = '';--}}
        {{--modal += '<div class="modal fade" id="widget-modal' + dashboardId + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';--}}
        {{--modal += '  <div class="modal-dialog modal-lg">';--}}
        {{--modal += '    <div class="modal-content">';--}}
        {{--modal += '      <div class="modal-header">';--}}
        {{--modal += '        <h5 class="modal-title" id="exampleModalLabel">Dashboard Preview</h5>';--}}
        {{--modal += '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';--}}
        {{--modal += '          <span aria-hidden="true">&times;</span>';--}}
        {{--modal += '        </button>';--}}
        {{--modal += '      </div>';--}}
        {{--modal += '      <div class="modal-body">';--}}
        {{--modal += '          <iframe class="widget" style="width: 100%; height: 570px" src="{{ $settings->kibana_preview_url}}/app/kibana#/dashboard/' + dashboardId + '?embed=true&_g=()"></iframe>';--}}
        {{--modal += '      </div>';--}}
        {{--modal += '      <div class="modal-footer">';--}}
        {{--modal += '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';--}}
        {{--modal += '      </div>';--}}
        {{--modal += '    </div>';--}}
        {{--modal += '  </div>';--}}
        {{--modal += '</div>';--}}
        // $("#previewModal").html(modal);
        // $("#widget-modal" + dashboardId).modal('show');
    }
</script>
