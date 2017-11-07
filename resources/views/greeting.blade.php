@extends('layouts.app')
@section('title', '使いやすい家計簿')
@section('content')


{{$message}}
<div class="row">
  <div class = "col-md-offset-6 col-md-2">
    <a href="/list" class="btn btn-lg btn-success btn-block" type="button">My家計簿を見る</a>
  </div>
  <div class = "col-md-2">
    <a href="/income" class="btn btn-lg btn-warning btn-block" type="button">収入を追加する</a>
  </div>
  <div class = "col-md-2">
    <a href="/logout" class="btn btn-lg btn-danger btn-block" type="button">ログアウト</a>
  </div>
</div>
<div class="row" style="margin-top: 50px">
  <div class="col-sm-3">
    <h5>今月の合計支出</h5>
  </div>
  <div class="col-sm-6">
    <form class="form-signin" role="form" method="post" action="">
      <div class="form-group">
        <h4>簡単入力レシート</h4>
        {{-- CSRF対策 --}}
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form-inline" style="margin-top: 10px">
          <label for="tag_name">商品名　：</label>
          <input type="text" name="title" id="tag_name" class="form-control" placeholder="商品名を入力" required autofocus>
        </div>
        <div class="form-inline">
        <label for="tag_price">価格　　：</label>
        <input type="text" name="price" id="tag_price" class="form-control" data-format="$1 円" pattern="^[1-9][0-9]*$" placeholder="値段を入力" required>
        </div>
        <div class="form-inline">
          <label for="tag_days">購入日付：</label>
        <input type="date" name="purchased_at" id="tag_days" class="form-control" value="today" required>
        </div>
        <div class="row" style="margin-top: 30px ;margin-left: auto;margin-right: auto;">
          <button class="btn btn-lg btn-primary" type="submit">送信</button>
        </div>
      </div>
    </form>
    </form>
  </div>
  <div class="col-sm-3">
  </div>
</div>


@endsection
