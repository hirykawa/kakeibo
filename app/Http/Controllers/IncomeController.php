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
        #incomeテーブル一覧取得
        $data = App\Income::where('user_id',$user_id)->get();

        # data連想配列に代入&Viewファイルをincome.blade.phpに指定
        return view('income.index', ['data' => $data , 'message' => 'ここで収入の管理を行いましょう']);
    }

    public function Create(Request $request){
        #incomeをテーブルに挿入
        $income = new App\Income();
        $income->user_id = Auth::id();
        $income->title = $request->input('title');
        $income->price = $request->input('price');
        $income->purchased_at = $request->input('purchased_at');
        $income->save();
        #incomeテーブル一覧取得
        $data = App\Income::where('user_id',Auth::id())->get();
        return view('income.index', ['data' => $data ,'message' => '記入ありがとうございました！']);
    }

    public function Edit(Request $request){
        #どのレコードを編集するか取得
        $id = $request->input('id');
        $data = App\Income::find($id);
        #検索結果をビューに渡す
        return view('income.edit', ['data' => $data , 'message' => '収入の編集をしましょう']);
    }

    public function Update(Request $request){
        $id = $request->input('id');
        #Updateするレコードを検索
        $income = App\Income::find($id);
        #POSTされた更新データを受け取る
        $income->title = $request->title;
        $income->price = $request->price;
        $income->purchased_at = $request->purchased_at;
        #更新する
        $income->save();
        #incomeテーブル一覧取得
        $data = App\Income::where('user_id',Auth::id())->get();

        #リダイレクトで一覧に戻る
        return redirect()->to('/income');
    }

    public function Destroy(Request $request){
        $id = $request->input('id');
        #kakiboテーブルから$idのレコードを検索
        $data = App\Income::find($id);
        #レコードの削除
        $data->delete();
        #リダイレクトでリスト一覧に戻る
        return redirect()->to('/income');
    }
}
