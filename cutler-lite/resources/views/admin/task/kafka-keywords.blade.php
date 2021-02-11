@if($keywords->count() > 0)
    <table class="table display nowrap">
        <thead>
        <tr>
            <th><strong>Keyword</strong></th>
            <th><strong>Start Date</strong></th>
            <th><strong>End Date</strong></th>
            <th><strong>Status</strong></th>
        </tr>
        </thead>
        @foreach($keywords as $keyword)
            <tr>
                <td>{{ $keyword->keyword }}</td>
                <td>{{ $keyword->start_date }}</td>
                <td>{{ $keyword->end_date }}</td>
                <td>
                    @if($keyword->status==0)
                        <span class="label label-default">Started</span>
                    @elseif($keyword->status==1)
                        <span class="label label-success">True</span>
                    @elseif($keyword->status==2)
                        <span class="label label-danger">False</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endif
