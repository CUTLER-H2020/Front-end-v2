@foreach($taskComments as $taskComment)
    <div class="mt-comment" @if($loop->last)style="background-color: #f9f9f9" @endif>
        <div class="mt-comment-body">
            <div class="mt-comment-info">
                <span class="mt-comment-author">{{ $taskComment->user()->first()->name.' '.$taskComment->user()->first()->surname }}</span>
                <span class="mt-comment-date">{{ \Carbon\Carbon::parse($taskComment->created_at)->format('Y-M-d H:i') }}</span>
            </div>
            <div
                class="mt-comment-text">
                <strong>Task:</strong> {{ $taskComment->xml_task_name }}<br />
                <strong>Comment:</strong> {!! $taskComment->comment !!}
            </div>
        </div>
    </div>
@endforeach
