<?php

// 以下緑文字の宣言を使うことにより緑文字ファイル内のメソッドを簡単に呼び出せる
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tweets', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tweets', function (Blueprint $table) {
            //user_idカラムに設定されている外部キー制約(テーブル間でのデータの整合性を維持する)を削除する操作
            $table->dropForeign(['user_id']);
            //tweetsテーブルからuser_idカラムを削除する操作
            $table->dropColumn(['user_id']);
        });
    }
};
