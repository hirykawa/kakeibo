@extends('layouts.app')
@section('title', 'レシート編集画面')
@section('content')

<div class="row">
    <div class = "col-md-5">
        {{$message}}
    </div>
  <div class = "col-md-offset-5 col-md-2">
    <a href="/list" class="btn btn-lg btn-primary btn-block" type="button">リスト一覧に戻る</a>
  </div>
</div>

<form class="form-signin" role="form" method="post" action="/list/update">
    <div class="form-group text-center">
        {{-- CSRF対策 --}}
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" value="{{ $data->id }}">
        <div class="form-inline" style="margin-top: 10px">
            <label for="tag_name">商品名　：</label>
            <input type="text" name="title" id="tag_name" class="form-control" value="{{ $data->title }}" placeholder="商品名を入力" required autofocus>
        </div>
        <div class="form-inline">
            <label for="tag_price">価格　　：</label>
            <input type="text" name="price" id="tag_price" class="form-control" data-format="$1 円" value="{{ $data->price }}" pattern="^[1-9][0-9]*$" placeholder="値段を入力" required>
        </div>
        <div class="form-inline">
            <label for="tag_days">購入日付：</label>
            <input type="date" name="purchased_at" id="tag_days" class="form-control" value="{{ $data->purchased_at }}" required>
        </div>
        <div class="row" style="margin-top: 30px ;margin-left: auto;margin-right: auto;">
            <button class="btn btn-lg btn-warning" type="submit">変更する</button>
        </div>
    </div>
</form>


@endsection
