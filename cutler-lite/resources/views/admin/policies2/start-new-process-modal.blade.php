<!-- Modal -->
<div class="modal fade" id="startNewProcessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('translation.general.policies.start-new-process') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="buttons-div">
                @for($i = 0; $i < count($newProcessList); $i++)
                    <button class="btn btn-primary btn-lg btn-block" @if($newProcessList[$i]['disabledButton'] == true ) disabled @endif onclick="startNewProcess('{{ $newProcessList[$i]['id'] }}', '{{ $newProcessList[$i]['name'] }}')">{{ $newProcessList[$i]['name'] }}</button>
                @endfor
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
