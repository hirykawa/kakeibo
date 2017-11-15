<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Carbon\Carbon;

class GreetingController extends Controller
{
    #getでgreeting/indexにアクセスした時の処理
    public function getIndex()
    {
        #ログイン中のユーザーidを取得
        $user = Auth::user();
        $user_id = Auth::id();
        #今月の収入を取得
        $total_income = $this->getIncome($user_id);
        #今月の支出を取得
        return view('greeting', ['message' => $user->name . 'さんこんにちは！今日もレシートをつけて行きましょう！','month' => $month, 'result' => '']);
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
        $kakeibo->user_id = Auth::id();
        $kakeibo->price = $price;
        $kakeibo->purchased_at = $purchased_at;
        $kakeibo->created_at = Carbon::now();
        $kakeibo->save();
        #month取得
        $month = date('n');
        return view('greeting', ['message' => '記入ありがとうございました！', 'result' => '記入完了しました!','month' => $month]);
    }

    public function getIncome($user_id){
        $total_income = 0;
        $month = date('n');
        $year = date('Y');
        $start = Carbon::createFromDate($year, $month, 1);
        $end = Carbon::createFromDate($year, $month, 31);
        $total_incomes = App\Income::where('user_id', $user_id)->get();
        foreach ($total_incomes as $income) {
            if($income->purchased_at > $start && $income->purchased_at < $end){
                $total_income += $income->price;
            }
        }
        return $total_income;
    }
}
