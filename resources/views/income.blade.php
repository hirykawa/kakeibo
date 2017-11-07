@extends('layouts.app')
@section('title', '使いやすい家計簿')
@section('content')

    {{$message}}

    <div class="row">
        <div class="col-md-offset-8 col-md-2">
            <a href="/list" class="btn btn-lg btn-success btn-block" type="button">My家計簿を見る</a>
        </div>
        <div class="col-md-2">
            <a href="/logout" class="btn btn-lg btn-danger btn-block" type="button">ログアウト</a>
        </div>
    </div>

    <div class="row" style="margin-top: 50px">
        <div class="col-sm-3">
            {{--<h5>先月の収入</h5>--}}
        </div>
        <div class="col-sm-6">
            <form class="form-signin" role="form" method="post" action="">
                <div class="form-group">
                    <h4>今月の収入</h4>
                    {{-- CSRF対策 --}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-inline" style="margin-top: 10px">
                        <label for="tag_name">種類　　：</label>
                        <select class="form-control" id="genre" name="income_genre">
                            <option value="1">臨時収入</option>
                            <option value="2" selected="selected">会社</option>
                            <option value="3">その他　</option>
                        </select>
                        {{--<input type="text" name="title" id="tag_name" class="form-control" placeholder="商品名を入力" required autofocus>--}}
                    </div>
                    <div class="form-inline">
                        <label for="tag_price">収入　　：</label>
                        <input type="text" name="price" id="tag_price" class="form-control" data-format="$1 円"
                               pattern="^[1-9][0-9]*$" placeholder="値段を入力" required>
                    </div>
                    <div class="form-inline">
                        <label for="tag_days">受取日付：</label>
                        <input type="date" name="purchased_at" id="tag_days" class="form-control" value="today"
                               required>
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