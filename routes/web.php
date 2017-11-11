<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// get の方がデバッグしやすい。かつ、データ取得系なのでgetメソッドを利用
Route::get('/sort', 'SortController@index')->middleware('auth');
Route::get('/', 'GreetingController@getIndex')->middleware('auth');
Route::post('/', 'GreetingController@postIndex')->middleware('auth');
Route::post('/list/edit','ListController@Edit')->middleware('auth');
Route::post('/list/update','ListController@Update')->middleware('auth');
Route::post('/list/destroy','ListDestroyController@Index')->middleware('auth');
Route::get('/list', 'ListController@Index')->middleware('auth');
//収入
Route::get('/income', 'IncomeController@Index')->middleware('auth');
Route::post('/income', 'IncomeController@Create')->middleware('auth');
Route::post('/income/edit','IncomeController@Edit')->middleware('auth');
Route::post('/income/update','IncomeController@Update')->middleware('auth');
Route::post('/income/destroy','IncomeController@Destroy')->middleware('auth');

// ログアウトしてホームにリダイレクトする。
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
