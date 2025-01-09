<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('item_name');
            $table->string('condition');
            $table->string('status');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->timestamp('created_at')->nullable(); // created_at カラム
            $table->timestamp('updated_at')->nullable(); // updated_at カラム
            $table->softDeletes(); // deleted_at カラム

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
