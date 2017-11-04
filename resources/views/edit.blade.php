@extends('layouts.master')
@section('title', 'レシート編集画面')
@section('content')

{{$message}}
<div class="row">
  <div class = "col-md-offset-10 col-md-2">
    <a href="/list" class="btn btn-lg btn-primary btn-block" type="button">リスト一覧に戻る</a>
  </div>
</div>

<form class="form-signin" role="form" method="post" action="/list/update">
{{-- CSRF対策 --}}
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="id" value="{{ $data->id }}">
<label for="tag_name">商品名：</label>
<input type="text" name="title" id="tag_name" class="form-control" value="{{ $data->title }}" placeholder="商品名を入力" required autofocus>
<label for="tag_price">価格：</label>
<input type="number" name="price" id="tag_price"class="form-control" value="{{ $data->price }}" data-format="$1 円" placeholder="値段を入力" required>
<label for="tag_days">購入した日付：</label>
<input type="date" name="purchased_at" id="tag_days" class="form-control" value="{{ $data->purchased_at }}" value="today" required>
<div class="row">
    <button class="btn btn-lg btn-warning btn-block" type="submit">変更する</button>
</div>
</form>


@endsection
