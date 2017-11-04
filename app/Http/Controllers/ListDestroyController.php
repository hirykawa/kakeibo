<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Carbon\Carbon;

class ListDestroyController extends Controller
{
  public function Index(Request $request) {
    $id = $request->input('id');
    #kakiboテーブルから$idのレコードを検索
    $data = App\kakeibo::find($id);
    #レコードの削除
    $data->delete();
    #リダイレクトでリスト一覧に戻る
    return redirect()->to('/list');

  }
}
