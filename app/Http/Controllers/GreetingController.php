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
        #支出の種類ごとを取得
        $outcome = $this->getOutcome($user_id,'title');
        #無駄遣いを計算
        $need = $this->calUseless($user_id,date('n'),date('Y'));
        #1週間分の結果
        $week_outcome = $this->outOneweak($user_id,date('j'),date('n'),date('Y'));
        return view('greeting', ['message' => $user->name . 'さんこんにちは！今日も家計簿をつけて行きましょう！','bop'=>$bop,'outcome' => $outcome,'need'=>$need,'week_outcome'=>$week_outcome, 'result' => '']);
    }

    #postでgreeting/indexにアクセスしたときの処理
    public function postIndex(Request $request)
    {
        $user_id = Auth::id();
        $title = $request->input('title');
        $price = $request->input('price');
        $detail = $request->input('detail');
        if($request->input('needs') == NULL){
            $needs = 0;
        }elseif ($request->input('needs') == 1){
            $needs = 1;
        }
        $purchased_at = $request->input('purchased_at');
        $kakeibo = new App\kakeibo();
        $kakeibo->title = $title;
        #user_idを取得
        $kakeibo->user_id = $user_id;
        $kakeibo->price = $price;
        $kakeibo->detail = $detail;
        $kakeibo->needs = $needs;
        $kakeibo->purchased_at = $purchased_at;
        $kakeibo->created_at = Carbon::now();
        $kakeibo->save();
        #収支を取得
        $bop = $this->balanceOfPayment($user_id);
        #支出の種類ごとを取得
        $outcome = $this->getOutcome($user_id,'title');
        #無駄遣いを計算
        $need = $this->calUseless($user_id,date('n'),date('Y'));
        #1週間分の結果
        $week_outcome = $this->outOneweak($user_id,date('j'),date('n'),date('Y'));
        return view('greeting', ['message' => '記入ありがとうございました！','bop'=>$bop,'outcome' => $outcome,'need'=>$need,'week_outcome'=>$week_outcome, 'result' => '記入完了しました!']);
    }

    /*
     * 1週間分の支出
     * */
    public function outOneweak($user_id,$days,$month,$year){
        $week_outcome = array();
        $end = Carbon::createFromDate($year, $month, $days);
        $start = $end->copy()->subDays(6);
        $total_outcomes = App\kakeibo::where('user_id', $user_id)->get();
        for($i=0; $i<7;$i++){
            $use_day = $start->copy()->addDay($i);
            $week_outcome[$use_day->format('m月d日')] = 0;
        }
        foreach ($total_outcomes as $outcome) {
            if($outcome->purchased_at >= $start && $outcome->purchased_at <= $end){
                $use_day = Carbon::parse($outcome->purchased_at);
                $week_outcome[$use_day->format('m月d日')] = $outcome->price;
            }
        }
        return $week_outcome;
    }

    /*
     * 無駄遣い計算
     * */
    public function calUseless($user_id,$month,$year){
        $need_outcome = 0;
        $need_outcome_count = 0;
        $not_need_outcome = 0;
        $not_need_outcome_count = 0;
        $start = Carbon::createFromDate($year, $month, 1);
        $end = Carbon::createFromDate($year, $month, 31);
        $total_outcomes = App\kakeibo::where('user_id', $user_id)->get();
        foreach ($total_outcomes as $outcome) {
            if($outcome->purchased_at >= $start && $outcome->purchased_at <= $end){
                if($outcome->needs == 1){
                    $need_outcome += $outcome->price;
                    $need_outcome_count += 1;
                }else{
                    $not_need_outcome += $outcome->price;
                    $not_need_outcome_count += 1;
                }
            }
        }
        if($need_outcome+$not_need_outcome != 0){
            $parsent = round(($not_need_outcome / ($need_outcome+$not_need_outcome)) * 100,1);
            return ['need_outcome' => $need_outcome,
                'need_outcome_count'=>$need_outcome_count,
                'not_need_outcome'=>$not_need_outcome,
                'not_need_outcome_count'=>$not_need_outcome_count,
                'parsent'=>$parsent
            ];
        }else{
            return NULL;
        }

    }
    /*
     *
     * データを扱う関数
     * */

    public function getIncome($user_id){
        $total_income = 0;
        $month = date('n');
        $year = date('Y');
        $start = Carbon::createFromDate($year, $month, 1);
        $end = Carbon::createFromDate($year, $month, 31);
        $total_incomes = App\Income::where('user_id', $user_id)->get();
        foreach ($total_incomes as $income) {
            if($income->purchased_at >= $start && $income->purchased_at <= $end){
                $total_income += $income->price;
            }
        }
        return $total_income;
    }

    public function getOutcome($user_id,$total_or_title){
        $total_outcome = 0;
        $outcomes = array();
        for($i = 1; $i<7 ;$i++){
            $outcomes[$i] = 0;
        }
        $month = date('n');
        $year = date('Y');
        $start = Carbon::createFromDate($year, $month, 1);
        $end = Carbon::createFromDate($year, $month, 31);
        $total_outcomes = App\kakeibo::where('user_id', $user_id)->get();
        if($total_or_title == 'total'){
            foreach ($total_outcomes as $income) {
                if($income->purchased_at >= $start && $income->purchased_at <= $end){
                    $total_outcome += $income->price;
                }
            }
            return $total_outcome;
        }else if($total_or_title == 'title'){
            foreach ($total_outcomes as $income) {
                if($income->purchased_at >= $start && $income->purchased_at <= $end){
                    $outcomes[$income->title] += $income->price;
                }
            }
            #最大値のkey
            $max_value = max($outcomes);
            $max_key = array_search($max_value,$outcomes);
            $outcomes['max_value'] = $max_value;
            $outcomes['max_key'] = $max_key;
            return $outcomes;
        }

    }

    public function balanceOfPayment($user_id){
        #今月の収入を取得
        $bop['income'] = $this->getIncome($user_id);
        #今月の支出を取得
        $bop['outcome'] = $this->getOutcome($user_id,'total');
        #今月残り使えるお金
        if($bop['income'] == 0){
            $bop['can_use'] = 0;
        }else{
            $bop['can_use'] = $bop['income'] - $bop['outcome'];
        }
        return $bop;
    }
}
