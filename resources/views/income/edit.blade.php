@extends('layouts.app')
@section('title', '収入編集')
@section('content')

<div class="row">
    <div class = "col-md-5">
        {{$message}}
    </div>
  <div class = "col-md-offset-5 col-md-2">
    <a href="/" class="btn btn-lg btn-primary btn-block" type="button">TOPに戻る</a>
  </div>
</div>

<form class="form-signin" role="form" method="post" action="/income/update">
    <div class="form-group text-center">
        {{-- CSRF対策 --}}
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" value="{{ $data->id }}">
        <div class="form-inline form-margin" style="margin-top: 10px">
            <label for="tag_name">種類　　：</label>
            <select class="form-control" id="tag_name" name="title">
                @if ($data->title == 1)
                    <option value="1" selected="selected">臨時収入</option>
                    <option value="2">会社　　</option>
                    <option value="3">その他　</option>
                @elseif ($data->title == 2)
                    <option value="1">臨時収入</option>
                    <option value="2" selected="selected">会社　　</option>
                    <option value="3">その他　</option>
                @else
                    <option value="1">臨時収入</option>
                    <option value="2">会社　　</option>
                    <option value="3" selected="selected">その他　</option>
                @endif
            </select>
        </div>
        <div class="form-inline">
            <label for="tag_price">金額　　：</label>
            <input type="text" name="price" id="tag_price" class="form-control form-margin" data-format="$1 円" value="{{ $data->price }}" pattern="^[1-9][0-9]*$" placeholder="値段を入力" required>
        </div>
        <div class="form-inline">
            <label for="tag_days">受取日付：</label>
            <input type="date" name="purchased_at" id="tag_days" class="form-control form-margin" value="{{ $data->purchased_at }}" required>
        </div>
        <div class="row" style="margin-top: 30px ;margin-left: auto;margin-right: auto;">
            <button class="btn btn-lg btn-warning" type="submit">変更する</button>
        </div>
    </div>
</form>


@endsection
