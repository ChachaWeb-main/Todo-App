<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    # 基本的な処理の流れ
    /*===================================================================================
    1. LaravelのRequestクラスを使ってフォームから送信された入力内容を取得する
    2. バリデーションを設定し、フォームに値が入力されているかどうかチェックする
    3. Tagモデルをインスタンス化して新しいデータ（テーブルのレコード）を作成する
    4. フォームから送信された入力内容（タグの名前）をnameカラムに代入する
    5. 現在ログイン中のユーザーのIDをuser_idカラムに代入する
    6. tagsテーブルにデータを保存する
    7. トップページ（Goalコントローラのindexアクション）にリダイレクトさせる
    ===================================================================================*/
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $tag = new Tag();
        $tag->name = $request->input('name');
        $tag->user_id = Auth::id();
        $tag->save();

        return redirect()->route('goals.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $tag->name = $request->input('name');
        $tag->user_id = Auth::id();
        $tag->save();

        return redirect()->route('goals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('goals.index');
    }
}
