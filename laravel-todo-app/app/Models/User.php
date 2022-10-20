<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*====================
        リレーション
    ====================*/
    # 目標のリレーション設定 １(ユーザー) 対 多(目標)  ※1人のユーザーは複数の目標を持つ
    public function goals() {
        return $this->hasMany(Goal::class);
    }

    # Todoのリレーション設定 １(ユーザー) 対 多(Todo)  ※1人のユーザーは複数のTodoを持つ
    public function todos() {
        return $this->hasMany(Todo::class);
    }

    # タグのリレーション設定 １(ユーザー) 対 多(Tag)  ※1人のユーザーは複数のTagを持つ
    public function tags() {
        return $this->hasMany(Tag::class);
    }
}
