<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//tweetがmodelというclassを受け継いでいるのでDB操作の多くの機能を利用できる
//classは特定のデータとメソッドを持つオブジェクトを定義する
class Tweet extends Model
{
    //ダラーguardedはアプリ側から変更できないカラムを指定している
    use HasFactory;
    protected $guarded = [
    'id',
    'created_at',
    'updated_at',
  ];

  public static function getAllOrderByUpdated_at()
  {
    //ここでselfとはtweetモデルのこと.
    //get以下がないと実行されない
    return self::orderBy('updated_at', 'desc')->get();
  }
  public function user()
  {
    // tweetモデルはuserモデルに属している状態
    return $this->belongsTo(User::class);
  }

  public function users()
  {
    return $this->belongsToMany(User::class)->withTimestamps();
  }
}
