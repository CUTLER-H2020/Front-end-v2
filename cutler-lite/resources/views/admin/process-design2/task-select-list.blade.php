<option>{{ trans('translation.general.task-select-list.select-task') }}</option>
@foreach($tasks as $task)
    <option value="{{ $task->xml_task_id }}">{{ $task->xml_name }}</option>
@endforeach
