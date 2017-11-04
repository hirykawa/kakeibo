@foreach($data as $row)
 <tr>
 <td>{{ $row->title }}</td>
 <td>{{ $row->price }}</td>
 <td>{{ $row->purchased_at }}</td>
 <td>{{ $row->created_at }}</td>
 <td>{{ $row->updated_at }}</td>
 <td>
   <form method="post" action="/list/edit">
     <input type="hidden" name="_token" value="{{csrf_token()}}">
     <input type="hidden" name="id" value="{{ $row->id }}">
     <input type="submit" value="編集" class="btn btn-primary btn-sm">
   </form>
 </td>
 <td>
    <form method="post" action="/list/destroy">
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <input type="hidden" name="id" value="{{ $row->id }}">
      <input type="submit" value="削除" class="btn btn-danger btn-sm btn-destroy">
    </form>
 </td>
 </tr>
@endforeach
