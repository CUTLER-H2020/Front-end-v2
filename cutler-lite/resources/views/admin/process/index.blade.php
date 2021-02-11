@extends('admin.parent')

@section('title', trans('translation.general.process-design.processes'))

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
                    <h1>{{ trans('translation.general.process.process') }}</h1>
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
                    <span class="active">{{ trans('translation.general.process.process') }}</span>
                </li>
            </ul>

            <!-- END PAGE BREADCRUMB -->
            <!-- END PAGE BREADCRUMB -->
            <hr>

            <div class="row">
                <div class="col-md-6">

                    <h4><span
                            style="width:180px !important; display:block; float:left; font-weight:500;">{{ trans('translation.general.task-show.policy-name') }}</span>
                        : <span
                            class="policyName">{{ $startedProcesses->first()->policy->name ?? $completedProcesses->first()->policy->name }}</span>
                    </h4>
                    <h4><span
                            style="width:180px !important; display:block; float:left; font-weight:500;">{{ trans('translation.general.process.policy-created-by') }}</span>
                        :
                        <span>{{ $startedProcesses->first()->createdUser->full_name ?? $completedProcesses->first()->createdUser->full_name }}</span>
                    </h4>
                    <h4>
                        <span
                            style="width:180px !important; display:block; float:left; font-weight:500;">{{ trans('translation.general.process.policy-created-date') }}</span>
                        :
                        @if(isset($startedProcesses->first()->policy))
                            <span>{{ \Carbon\Carbon::parse($startedProcesses->first()->policy->created_at)->format('d-m-Y H:i') }}</span>
                        @else
                            <span>{{ \Carbon\Carbon::parse($completedProcesses->first()->policy->created_at)->format('d-m-Y H:i') }}</span>
                        @endif
                    </h4>
                </div>
                <div class="col-md-6">
                    @if(empty($startedProcesses->first()->policy->image))
                        <img src="{{ asset('uploads/policy/no-image.png') }}" style="width: 100px; height: 100px"
                             alt="">
                    @else
                        <img src="{{ asset('uploads/policy/'. $startedProcesses->first()->policy->image) }}"
                             style="width: 100px; height: 100px" alt="">
                    @endif

                </div>
            </div>


            <hr>
            <!-- BEGIN PAGE BASE CONTENT -->
            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            <strong>{{ trans('translation.general.success') }}</strong> {!! Session::get('success_message') !!}
                        </div>
                    @endif

                    <button class="btn btn-success" id="getUserProcess"><i
                            class="fa fa-user"></i> {{ Auth::user()->name.' '.Auth::user()->surname }} Processes
                    </button>
                    <button class="btn btn-primary" id="getAllProcess"><i class="fa fa-list"></i> All Processes</button>
                    <br/><br/>

                    <div id="processes">
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    {{ trans('translation.general.process.started-process-list') }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('translation.general.process.process') }}</th>
                                            <th>{{ trans('translation.general.process.task-name') }}</th>
                                            <th>{{ trans('translation.general.process.phase') }}</th>
                                            <th>{{ trans('translation.general.task-show.process-started-by') }}</th>
                                            <th>{{ trans('translation.general.task-show.process-started-time') }}</th>
                                            <th width="21%"> {{ trans('translation.general.process.actions') }} </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($startedProcesses->count() > 0)
                                            @foreach($startedProcesses as $process)
                                                <tr class="@if(empty($process->activeTask->phase)) success @endif">
                                                    <td>{{ $process->xml_process_name }} </td>
                                                    <td>{{ $process->activeTask->xml_task_name ?? 'All Task Completed' }}</td>
                                                    <td>{{ $process->activeTask->phase ?? 'Completed' }} </td>
                                                    <td>{{ $process->startedUser->full_name }} </td>
                                                    <td>{{ \Carbon\Carbon::parse($process->started_at)->format('d-m-Y H:i') }} </td>
                                                    <td>
                                                        <a type="button"
                                                           href="{{ route('task.index', ['xmlProcessId' => $process->xml_process_id, 'xmlInstanceId' => $process->xml_instance_id]) }}"
                                                           class="btn btn-primary"><i
                                                                class="fa fa-forward"></i> {{ trans('translation.general.process.go-to-process') }}
                                                        </a>
                                                        @if(Auth::user()->group->name == "Pilot Administrators")
                                                            <a type="button"
                                                               href="{{ route('deleteProcess', $process->xml_instance_id) }}"
                                                               class="btn btn-danger delete-button"><i
                                                                    class="fa fa-trash"></i> {{ trans('translation.general.delete-process') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6"
                                                    class="text-center">{{ trans('translation.general.process.process-not-found') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <div class="caption">
                                    {{ trans('translation.general.process.completed-process-list') }}
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('translation.general.process.process') }}</th>
                                            <th>{{ trans('translation.general.task-show.process-started-by') }}</th>
                                            <th>{{ trans('translation.general.task-show.process-started-time') }}</th>
                                            <th>{{ trans('translation.general.process.end-time') }}</th>
                                            <th width="21%"> {{ trans('translation.general.process.actions') }} </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($completedProcesses->count() > 0)
                                            @foreach($completedProcesses as $process)
                                                <tr class="@if($process->completed == 1) success @endif">
                                                    <td>{{ $process->xml_process_name }} </td>
                                                    <td>{{ $process->startedUser->full_name }} </td>
                                                    <td>{{ \Carbon\Carbon::parse($process->started_at)->format('d-m-Y H:i:s') }} </td>
                                                    <td>{{ \Carbon\Carbon::parse($process->completed_at)->format('d-m-Y H:i:s') }}</td>
                                                    <td>
                                                        <a type="button"
                                                           href="{{ route('task.index', ['xmlProcessId' => $process->xml_process_id, 'xmlInstanceId' => $process->xml_instance_id]) }}"
                                                           class="btn btn-primary disabled-button"><i
                                                                class="fa fa-forward"></i> {{ trans('translation.general.process.go-to-process') }}
                                                        </a>
                                                        @if(Auth::user()->group->name == "Pilot Administrators")
                                                            <a type="button"
                                                               href="{{ route('deleteProcess', $process->xml_instance_id) }}"
                                                               class="btn btn-danger delete-button"><i
                                                                    class="fa fa-trash"></i> {{ trans('translation.general.delete-process') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5"
                                                    class="text-center">{{ trans('translation.general.process.process-not-found') }}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">{{ trans('translation.general.process.start-new-process') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="buttons-div"></div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#getUserProcess').on('click', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('getUserProcess')}}",
                type: "POST",
                data: {policy_id: {{ $policyId }}},
                success: function (response) {
                    $('#getUserProcess').removeClass('btn-primary').addClass('btn-success');
                    $('#getAllProcess').removeClass('btn-success').addClass('btn-primary');
                    $('#processes').html(response);
                }
            });
        })

        $('#getAllProcess').on('click', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('getAllProcess')}}",
                type: "POST",
                data: {policy_id: {{ $policyId }}},
                success: function (response) {
                    $('#getUserProcess').removeClass('btn-success').addClass('btn-primary');
                    $('#getAllProcess').removeClass('btn-primary').addClass('btn-success');
                    $('#processes').html(response);
                }
            });
        })
    </script>
@endsection
