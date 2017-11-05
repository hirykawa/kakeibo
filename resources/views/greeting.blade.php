@extends('layouts.app')
@section('title', '使いやすい家計簿')
@section('content')


{{$message}}
<div class="row">
  <div class = "col-md-offset-8 col-md-2">
    <a href="/logout" class="btn btn-lg btn-danger btn-block" type="button">ログアウト</a>
  </div>
  <div class = "col-md-2">
    <a href="/list" class="btn btn-lg btn-success btn-block" type="button">My家計簿を見る</a>
  </div>
</div>

<form class="form-signin" role="form" method="post" action="">
{{-- CSRF対策 --}}
<input type="hidden" name="_token" value="{{csrf_token()}}">
<label for="tag_name">商品名：</label>
<input type="text" name="title" id="tag_name" class="form-control" placeholder="商品名を入力" required autofocus>
<label for="tag_price">価格：</label>
<input type="number" name="price" id="tag_price"class="form-control" data-format="$1 円" placeholder="値段を入力" required>
<label for="tag_days">購入した日付：</label>
<input type="date" name="purchased_at" id="tag_days" class="form-control" value="today" required>
<div class="row" style="margin-top: 30px">
    <button class="btn btn-lg btn-primary btn-block" type="submit">送信</button>
</div>
</form>



@endsection
