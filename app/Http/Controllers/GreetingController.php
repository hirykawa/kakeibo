<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Carbon\Carbon;

class GreetingController extends Controller
{
  #getでgreeting/indexにアクセスした時の処理
  public function getIndex() {
    #ログイン中のユーザーidを取得
    $user = Auth::user();
    return view('greeting', ['message' => $user->name.'さんこんにちは！今日もレシートをつけて行きましょう！','result' => '']);
  }


  #postでgreeting/indexにアクセスしたときの処理
  public function postIndex(Request $request)
  {

  $title = $request->input('title');
  $price = $request->input('price');
  $purchased_at = $request->input('purchased_at');
  $kakeibo = new App\kakeibo();
  $kakeibo->title = $title;
  #user_idを取得
  $kakeibo->user_id = Auth::id();;
  $kakeibo->price = $price;
  $kakeibo->purchased_at = $purchased_at;
  $kakeibo->created_at = Carbon::now();
  $kakeibo->save();
  return view('greeting', ['message' => '記入ありがとうございました！','result' => '記入完了しました!']);
  }
}
