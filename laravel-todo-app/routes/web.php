<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TagController;

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

/* エラー解消 => ログイン認証を行うため、認証したいルーティングの末尾にmiddleware('auth')メソッドをつなげる */
Route::get('/', [GoalController::class, 'index'])->middleware('auth');

# 記述するだけで、アカウント作成ページやログインページ、パスワードの再設定ページなど、各種コントローラ、アクションへのルーティングを設定してくれる。
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
# Goal用のルーティング
Route::resource('goals', GoalController::class)->only(['index', 'store', 'update', 'destroy'])->middleware('auth');
# ToDo用のルーティング
Route::resource('goals.todos', TodoController::class)->only(['store', 'update', 'destroy'])->middleware('auth');
# Tag用のルーティング
Route::resource('tags', TagController::class)->only(['store', 'update', 'destroy'])->middleware('auth');
