<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    # データの一覧ページを表示する
    /*=================================================================================================
    1. 現在ログイン中のユーザーが持つ目標をすべて取得し、変数$goalsに代入する
    2. view()ヘルパーを使ってビュー［resources/views/goals/index.blade.php（次章で作成）］を表示する
    3. view()ヘルパーの第2引数にPHPのcompact()関数を指定し、変数$goalsをビューに渡す
    =================================================================================================*/
    public function index()
    {
        $goals = Auth::user()->goals;
        $tags = Auth::user()->tags;

        return view('goals.index', compact('goals', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    # 作成機能
    /*===================================================================================
    1. LaravelのRequestクラスを使ってフォームから送信された入力内容を取得する
    2. バリデーションを設定し、フォームに値が入力されているかどうかチェックする
    3. Goalモデルをインスタンス化して新しいデータ（テーブルのレコード）を作成する
    4. フォームから送信された入力内容（目標のタイトル）をtitleカラムに代入する
    5. 現在ログイン中のユーザーのIDをuser_idカラムに代入する
    6. goalsテーブルにデータを保存する
    7. トップページ（indexアクション）にリダイレクトさせる
    ===================================================================================*/
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $goal = new Goal();
        $goal->title = $request->input('title');
        $goal->user_id = Auth::id();
        $goal->save();

        return redirect()->route('goals.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */

    # 更新機能
    /*=======================================================================================================
    ・どのデータを更新するか」という情報が必要なので、Goalモデルのインスタンス（$goal）を受け取る。
    ・新しくデータを作成するわけではなく受け取ったデータ（$goal＝Goalモデルのインスタンス）を更新するため、
    goal = new Goal();でインスタンス化する必要がない。
    =======================================================================================================*/
    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $goal->title = $request->input('title');
        $goal->user_id = Auth::id();
        $goal->save();

        return redirect()->route('goals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Goal  $goal
     * @return \Illuminate\Http\Response
     */

    # 削除機能
    /*================================================================================================================================
    ・受け取ったGoalモデルのインスタンスをdelete()メソッドで削除したあと、トップページ（indexアクション）にリダイレクトさせるだけ
    ================================================================================================================================*/
    public function destroy(Goal $goal)
    {
        $goal->delete();

        return redirect()->route('goals.index');
    }
}
