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
        #収支を取得
        $bop = $this->balanceOfPayment($user_id);
        return view('greeting', ['message' => $user->name . 'さんこんにちは！今日も家計簿をつけて行きましょう！','bop'=>$bop, 'result' => '']);
    }

    #postでgreeting/indexにアクセスしたときの処理
    public function postIndex(Request $request)
    {
        $user_id = Auth::id();
        $title = $request->input('title');
        $price = $request->input('price');
        $purchased_at = $request->input('purchased_at');
        $kakeibo = new App\kakeibo();
        $kakeibo->title = $title;
        #user_idを取得
        $kakeibo->user_id = $user_id;
        $kakeibo->price = $price;
        $kakeibo->purchased_at = $purchased_at;
        $kakeibo->created_at = Carbon::now();
        $kakeibo->save();
        #収支を取得
        $bop = $this->balanceOfPayment($user_id);
        return view('greeting', ['message' => '記入ありがとうございました！','bop'=>$bop, 'result' => '記入完了しました!']);
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

    public function getOutcome($user_id){
        $total_outcome = 0;
        $month = date('n');
        $year = date('Y');
        $start = Carbon::createFromDate($year, $month, 1);
        $end = Carbon::createFromDate($year, $month, 31);
        $total_outcomes = App\kakeibo::where('user_id', $user_id)->get();
        foreach ($total_outcomes as $income) {
            if($income->purchased_at > $start && $income->purchased_at < $end){
                $total_outcome += $income->price;
            }
        }
        return $total_outcome;
    }

    public function balanceOfPayment($user_id){
        #今月の収入を取得
        $bop['income'] = $this->getIncome($user_id);
        #今月の支出を取得
        $bop['outcome'] = $this->getOutcome($user_id);
        #今月残り使えるお金
        if($bop['income'] == 0){
            $bop['can_use'] = 0;
        }else{
            $bop['can_use'] = $bop['income'] - $bop['outcome'];
        }

        return $bop;
    }
}
