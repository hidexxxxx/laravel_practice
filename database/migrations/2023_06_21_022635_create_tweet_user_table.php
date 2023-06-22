<?php

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
        Schema::create('tweet_user', function (Blueprint $table) {
            $table->id();
            //フォーリンidで引数のカラムが外部キー制約である、コンストレインで参照するテーブルとカラムを設定、カスケードオンデリートで参照しているデータが削除された場合中間データも削除させる
            //カラム名が命名規則に則しているため()は空欄でOK
            $table->foreignId('tweet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //tweetとユーザーidが唯一の組み合わせである制約を設定している
            $table->unique(['tweet_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweet_user');
    }
};
