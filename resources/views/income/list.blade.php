@foreach($data as $row)
    <tr>
        @if ($row->title == 1)
            <td>臨時収入</td>
        @elseif ($row->title == 2)
            <td>会社</td>
        @else
            <td>その他</td>
        @endif
        <td>{{ $row->price }}円</td>
        <td>{{ $row->purchased_at }}</td>
        <td>
            <form method="post" action="/income/edit">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="submit" value="編集" class="btn btn-primary btn-sm">
            </form>
        </td>
        <td>
            <form method="post" action="/income/destroy">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="id" value="{{ $row->id }}">
                <input type="submit" value="削除" class="btn btn-danger btn-sm btn-destroy">
            </form>
        </td>
    </tr>
@endforeach