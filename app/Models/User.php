<?php

//今回はユーザとツイートが１対多の関係なので以下の記載にする

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
        'password' => 'hashed',
    ];

     public function userTweets()
    {
        //ハズメニーは今のメソッドが複数のtweetモデルと関連している
        return $this->hasMany(Tweet::class);
    }

    public function tweets()
    {
        //USERモデル(モデルとはデータ取得や削除などCRUD処理を行うテンプレート)とTweetモデルと対多の連携をする
        return $this->belongsToMany(Tweet::class)->withTimestamps();
    }
}
