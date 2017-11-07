<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function Index(){
        #ログイン中のユーザーidを取得
        $user_id = Auth::id();
        /*
        @todo
        incomeテーブル作成して渡す
        */
        #kakiboテーブル一覧取得

        # data連想配列に代入&Viewファイルをlist.blade.phpに指定
        return view('income', ['data' => '500' , 'message' => 'ここで収入の管理を行いましょう']);
    }
}
