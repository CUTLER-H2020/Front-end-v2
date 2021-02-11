@if($widgets->count() > 0)
    @foreach($widgets as $widget)
        <tr>
            <td>{{ $widget->widget_name }}</td>
            <td>{{ $widget->widget_title }}</td>
            <td>{{ $widget->widget_type }}</td>
            <td>
                <button onclick="previewModal('{{ $widget->widget_id }}')" class="btn btn-primary">{{ trans('translation.general.task-show.widget-preview') }}</button>
{{--                <iframe style="height: 150px" class="widget" src="http://{{ $settings->kibana_preview_url }}/app/kibana#/visualize/edit/{{ $widget->widget_id }}?embed=true&_g=()\"></iframe>--}}
            </td>
            <td><button onclick="deleteWidget({{ $widget->id }})" type="button" class="btn btn-danger"><i class="fa fa-trash"></i>{{ trans('translation.general.delete') }}</button></td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6" class="text-center">{{ trans('translation.general.task-show.no-widget') }}</td>
    </tr>
@endif
