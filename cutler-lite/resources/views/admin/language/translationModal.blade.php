@if($languages->count() > 0)
    @foreach($languages as $language)
        @if($language->status==1)
            <div class="form-group col-md-12">
                {!! Form::label('feature', $language->name, ['class' => 'col-md-12'])  !!}
                <div class="col-md-12">
                    @php
                        $code = $language->code;
                    @endphp
                    {!! Form::textarea('feature', $translation->$code, ['id' => $code, 'class' => 'form-control', 'style' => 'resize:none', 'cols' => '30', 'rows' => '3'])!!}
                </div>
            </div>
        @endif
    @endforeach
@endif

<div class="form-group col-md-12">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary" onclick="translationSave({{ $translation->id }})"><i
                class="fa fa-save"></i> {{ trans('translation.general.save-changes') }}</button>
    </div>
</div>

<script>
    function translationSave(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('language.translationSave')}}",
            type: "POST",
            data: {
                id: id,
                @if($languages->count() > 0)
                    @foreach($languages as $language)
                        @if($language->status==1)
                            {{ $language->code }}: $("#{{ $language->code }}").val(),
                        @endif
                    @endforeach
                @endif
            },
            dataType: "json",
            success: function (response) {
                if(response.status=="0"){
                    alert("{{ trans('translation.general.save-error') }}");
                } else if(response.status=="1"){
                    $("#translationModal").modal('hide');
                    alert("{{ trans('translation.general.save-success') }}");
                }
            }
        });
    }
</script>
