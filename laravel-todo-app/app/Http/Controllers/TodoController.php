<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    # 作成機能
    /*====================================================================================
    1. LaravelのRequestクラスを使ってフォームから送信された入力内容を取得する
    2. Goalモデルのインスタンス（$goal）を受け取る
    3. バリデーションを設定し、フォームに値が入力されているかどうかチェックする
    4. Todoモデルをインスタンス化して新しいデータ（テーブルのレコード）を作成する
    5. フォームから送信された入力内容（ToDoの内容）をcontentカラムに代入する
    6. 現在ログイン中のユーザーのIDをuser_idカラムに代入する
    7. 渡されたGoalモデルのインスタンスから目標のIDを取得し、goal_idカラムに代入する
    8. doneカラムに初期値のfalseを代入する（作成時点でToDoは未完了であるため）
    9. todosテーブルにデータを保存する
    10. トップページ（Goalコントローラのindexアクション）にリダイレクトさせる
    ===================================================================================*/
    #1・2
    public function store(Request $request, Goal $goal) {
        #3
        $request->validate([
            'content' => 'required',
        ]);

        $todo = new Todo(); #4
        $todo->content = $request->input('content'); #5
        $todo->user_id = Auth::id(); #6
        $todo->goal_id = $goal->id; #7
        $todo->done = false; #8
        $todo->save(); #9

        # sync()メソッドの引数に$request->input('tag_ids')を渡すことで、そのToDoとチェックされたタグを紐付けて中間テーブル（tag_todoテーブル）に保存できる
        $todo->tags()->sync($request->input('tag_ids'));

        return redirect()->route('goals.index'); #10

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    # 更新機能
    /*====================================================================================================================
    1. storeアクションと同様にgoal_idの値を保存する必要があるため、Goalモデルのインスタンス（$goal）を受け取る
    2. 「どのデータを更新するか」という情報が必要なので、Todoモデルのインスタンス（$todo）も受け取る
    3. ドロップダウンメニューの「編集」リンクをクリックし、ToDoの内容（contentカラムの値）を更新するパターン
    ドロップダウンメニューの「完了」または「未完了」ボタンをクリックし、ToDoの完了・未完了を切り替える（doneカラムの値を変更する）パターン
    ====================================================================================================================*/
    public function update(Request $request, Goal $goal, Todo $todo) {
        $request->validate([
            'content' => 'required',
        ]);

        # 1つ目のパターンではdoneカラムの値は変更しないので、doneカラムにはもともとの値である$todo->doneを代入。一方で、2のパターンではフォームから送信された入力内容（文字列の'true'または'false'）を取得し、その値を論理値（trueまたはfalse）に変換してからdoneカラムに代入。なお、フォームから送信された入力内容を論理値に変換するには、input()メソッドの代わりにboolean()メソッドを使う。input()メソッドやboolean()メソッドでは、第2引数を渡すことで第1引数に指定したフォームの入力値が存在しない場合の初期値を設定できる。つまり、updateアクション内で以下のように記述すれば上記2パターンの両方に対応できる。
        $todo->content = $request->input('content');
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->done = $request->boolean('done', $todo->done);
        $todo->save();

        # 「完了」と「未完了」の切り替え時でないとき（通常の編集時）にのみタグを変更する
        /*========================================================================================
        $requestに対してhas()メソッドを使うことで、
        「その値がフォームから送信されたかどうか」をチェックすることができる。
        'done'というname属性を持つinputタグの値がフォームから送信されなかったとき」に処理が実行
        ========================================================================================*/
        if (!$request->has('done')) {
            $todo->tags()->sync($request->input('tag_ids'));
        };

        return redirect()->route('goals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    # 削除機能
    # 引数はルーティングのネスト順（Goal $goal → Todo $todo）に設定しなければならない点に注意。
    public function destroy(Goal $goal, Todo $todo) {
        $todo->delete();

        return redirect()->route('goals.index');
    }
}
