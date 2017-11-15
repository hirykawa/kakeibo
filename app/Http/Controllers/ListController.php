<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Carbon\Carbon;

class ListController extends Controller
{
    public function Index(Request $request)
    {
        #ログイン中のユーザーidを取得
        $user_id = Auth::id();
        #kakiboテーブル一覧取得
        $data = App\kakeibo::where('user_id', $user_id)->get();
        # data連想配列に代入&Viewファイルをlist.blade.phpに指定
        return view('list', ['data' => $data, 'message' => 'ここが支出の一覧になります。']);
    }

    public function Edit(Request $request)
    {
        #どのレコードを編集するか取得
        $id = $request->input('id');
        $data = App\kakeibo::find($id);
        #検索結果をビューに渡す
        return view('edit', ['data' => $data, 'message' => '支出の編集をしましょう']);
    }

    public function Update(Request $request)
    {
        $id = $request->input('id');
        #Updateするレコードを検索
        $data = App\kakeibo::find($id);
        #POSTされた更新データを受け取る
        $data->title = $request->title;
        $data->price = $request->price;
        $data->purchased_at = $request->purchased_at;
        #更新する
        $data->save();
        #リダイレクトで一覧に戻る
        return redirect()->to('/list');
    }

}
