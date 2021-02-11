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
                                   class="btn btn-primary"><i class="fa fa-forward"></i> {{ trans('translation.general.process.go-to-process') }}</a>
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
                        <td colspan="6" class="text-center">{{ trans('translation.general.process.process-not-found') }}</td>
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
                                <a type="button" href="{{ route('task.index', ['xmlProcessId' => $process->xml_process_id, 'xmlInstanceId' => $process->xml_instance_id]) }}" class="btn btn-primary disabled-button">
                                    <i class="fa fa-forward"></i> {{ trans('translation.general.process.go-to-process') }}
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
                        <td colspan="5" class="text-center">{{ trans('translation.general.process.process-not-found') }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('.delete-button').on('click', function (event) {
        event.preventDefault();
        Swal.fire({
            title: '{{ trans('translation.general.sure') }}',
            text: '{{ trans('translation.general.cannot') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ trans('translation.general.delete-this') }}',
            cancelButtonText: '{{ trans('translation.general.cancel') }}'
        }).then((result) => {
            if (result.value) {
                window.location.href = $(this).attr('href');
            }
        });
    });

    $('.disabled-button').on('click', function () {
        $(this).attr('disabled', true).addClass('disabled');
        window.location.href = $(this).attr('href');
    })
</script>
