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
                @if(count($newProcessList) > 0)
                    @for($i = 0; $i < count($newProcessList); $i++)
                    @if($newProcessList[$i]['disabledButton'] == true )
                    <button class="btn btn-primary btn-lg btn-block startNewProcessBtn" disabled>{{ $newProcessList[$i]['name'] }}<br />
                    <span style="font-size:12px; font-weight:bold;">{{ trans('translation.general.policies.passive-process-description') }}</span></button>
                    @else
                    <button class="btn btn-primary btn-lg btn-block startNewProcessBtn" onclick="startNewProcess('{{ $newProcessList[$i]['id'] }}', '{{ $newProcessList[$i]['key'] }}', '{{ $newProcessList[$i]['name'] }}')">{{ $newProcessList[$i]['name'] }}</button>
                    @endif

                    @endfor
                @else
                    <div class="text-center">
                        {{ trans('translation.general.policies.no-assigned-process') }} <br>
                        {{ trans('translation.general.policies.ask-data-scientist') }}
                    </div>
                @endif
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
