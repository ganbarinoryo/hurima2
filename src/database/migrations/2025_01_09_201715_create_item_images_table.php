<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->string('image_url');
            $table->timestamp('created_at')->nullable(); // created_at カラム
            $table->timestamp('updated_at')->nullable(); // updated_at カラム
            $table->softDeletes(); // deleted_at カラム

            // 外部キー制約
            $table->foreign('item_id')->references('id')->on('items');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_images');
    }
}
