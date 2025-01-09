<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); // PRIMARY KEY
            $table->string('user_name', 255)->nullable(); // ユーザー名（後から入力）
            $table->string('email', 255)->unique()->notNullable(); // メールアドレス（必須）
            $table->string('password', 255)->notNullable(); // パスワード（必須）
            $table->string('postal_code', 10)->nullable(); // 郵便番号（後から入力）
            $table->string('address', 255)->nullable(); // 住所（後から入力）
            $table->string('building_name', 255)->nullable(); // 建物名（後から入力）
            
            $table->timestamp('created_at')->useCurrent(); // 作成日時（必須）
            $table->timestamp('updated_at')->nullable(); // 更新日時（任意）
            $table->timestamp('deleted_at')->nullable(); // 削除日時（ソフトデリート対応）
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
