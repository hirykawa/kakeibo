@extends('layouts.app')
@section('title', '使いやすい家計簿')
@section('content')


    <div class="row">
        <div class="col-md-5">
            {{$message}}
        </div>
        <div class="col-md-offset-3 col-md-2">
            <a href="/" class="btn btn-lg btn-success btn-block" type="button">TOPに戻る</a>
        </div>
        <div class="col-md-2">
            <a href="/logout" class="btn btn-lg btn-danger btn-block" type="button">ログアウト</a>
        </div>
    </div>

    <div class="row" style="margin-top: 50px">
        <div class="col-sm-1">

        </div>
        <div class="col-sm-4">
            <form class="form-signin" role="form" method="post" action="">
                <div class="form-group">
                    <h4>収入の追加</h4>
                    {{-- CSRF対策 --}}
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-inline" style="margin-top: 10px">
                        <label for="tag_name">種類　　：</label>
                        <select style="width: 170px" class="form-control form-margin" id="tag_name" name="title">
                            <option value="1">臨時収入</option>
                            <option value="2" selected="selected">会社　　</option>
                            <option value="3">その他　</option>
                        </select>
                    </div>
                    <div class="form-inline">
                        <label for="tag_price">収入　　：</label>
                        <input style="width: 170px" type="text" name="price" id="tag_price" class="form-control form-margin" data-format="$1 円"
                               pattern="^[1-9][0-9]*$" placeholder="値段を入力" required>  円
                    </div>
                    <div class="form-inline">
                        <label for="tag_days">受取日付：</label>
                        <input style="width: 170px" type="date" name="purchased_at" id="tag_days" class="form-control form-margin" value ="@php echo date('Y-m-j'); @endphp" required>
                    </div>
                    <div class="row" style="margin-top: 30px ;margin-left: auto;margin-right: auto;">
                        <button class="btn btn-lg btn-primary" type="submit">送信</button>
                    </div>
                </div>
            </form>
            </form>
        </div>
        <div class="col-sm-7">
            <h4>収入一覧</h4>
            <table class="table table-striped table-bordered table-responsive">
                <tr>
                    <th>種類<span class="glyphicon glyphicon-sort pull-right" onclick="nowalart('title')" aria-hidden="true">降順</span></th>
                    <th>金額<span class="glyphicon glyphicon-sort pull-right" onclick="nowalart('price')" aria-hidden="true">降順</span></th>
                    <th>受取日時<span class="glyphicon glyphicon-sort pull-right" onclick="nowalart('purchased_at')" aria-hidden="true">降順</span></th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
                <tbody id="response_body">
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
                </tbody>
            </table>
        </div>
    </div>

@endsection