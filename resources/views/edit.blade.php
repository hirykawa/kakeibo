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
    <div class="form-group">
        {{-- CSRF対策 --}}
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" value="{{ $data->id }}">
        <div class="form-inline" style="margin-top: 10px">
            <label for="tag_name">種類　　：</label>
            <select style="width: 170px" class="form-control form-margin" id="tag_name" name="title" required autofocus>
                <option value="1" @if ($data->title == 1) selected="selected" @endif>食費</option>
                <option value="2" @if ($data->title == 2) selected="selected" @endif>生活費(日用品)</option>
                <option value="3" @if ($data->title == 3) selected="selected" @endif>趣味・交際</option>
                <option value="4" @if ($data->title == 4) selected="selected" @endif>交通費</option>
                <option value="5" @if ($data->title == 5) selected="selected" @endif>家賃・水光熱・通信</option>
                <option value="6" @if ($data->title == 6) selected="selected" @endif>その他</option>
            </select>
        </div>
        <div class="form-inline">
            <label for="tag_price">価格　　：</label>
            <input type="text" name="price" id="tag_price" class="form-control form-margin" value="{{$data->price}}" data-format="$1 円" pattern="^[1-9][0-9]*$" placeholder="値段を入力" required>  円
        </div>
        <div class="form-inline">
            <label for="tag_days">購入日付：</label>
            <input type="date" name="purchased_at" id="tag_days" class="form-control form-margin" value="{{$data->purchased_at}}" required>
        </div>
        <div class="form-inline">
            <label for="tag_name">詳細　　：</label>
            <input type="text" name="detail" id="tag_detail" class="form-control form-margin" value="{{$data->detail}}" placeholder="備考があれば入力してください">
        </div>
        <div class="form-inline">
            <label for="tag_name">必要　　：</label>
            <input type="checkbox" name="needs" id="tag_needs" value="1" class="form-control form-margin" @if ($data->needs == 1) checked @endif>
        </div>
        <div class="row" style="margin-top: 30px ;margin-left: auto;margin-right: auto;">
            <button class="btn btn-lg btn-warning" type="submit">変更する</button>
        </div>
    </div>
</form>


@endsection
