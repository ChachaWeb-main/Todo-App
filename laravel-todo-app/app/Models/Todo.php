<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    # リレーション設定 １対１  ※1つのToDoは1人のユーザーおよび1つの目標のみに属する
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function goal() {
        return $this->belongsTo(Goal::class);
    }
    # 多対多  ※1つのToDoは複数のタグを持ち、同様に1つのタグは複数のToDoを持つ。また中間テーブルにはタイムスタンプ（created_atカラムとupdated_atカラムの値）が自動的に保存されないため、withTimestamps()メソッドをつなぐ。
    public function tags() {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
