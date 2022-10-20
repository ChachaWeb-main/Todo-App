<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    # リレーション設定 １対１  ※1つの目標は1人のユーザーのみに属する
    public function user() {
        return $this->belongsTo(User::class);
    }

    # リレーション設定 １(ユーザー) 対 多(目標)  ※1つの目標は複数のTodoを持つ
    public function todos() {
        return $this->hasMany(Todo::class);
    }
}
