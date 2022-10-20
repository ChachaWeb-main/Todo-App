<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    # リレーション設定 １対１  ※1つのTagは1人のユーザーのみに属する
    public function user() {
        return $this->belongsTo(User::class);
    }
    # 多対多  ※1つのTagは複数のTodoを持ち、同様に1つのTodoは複数のTagを持つ。また中間テーブルにはタイムスタンプ（created_atカラムとupdated_atカラムの値）が自動的に保存されないため、withTimestamps()メソッドをつなぐ。
    public function todos() {
        return $this->belongsToMany(Todo::class)->withTimestamps();
    }
}
