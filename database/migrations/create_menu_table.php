<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('name')->nullable('组件名称字段');
            $table->json('options')->nullable();
            $table->string('component')->nullable()->comment('组件');
            $table->string('redirect')->nullable()->comment('重定向');
            $table->boolean('is_header')->default(false)->nullable()->comment('显示位置 上');
            $table->boolean('is_aside')->default(false)->nullable()->comment('显示位置 左');
            $table->integer('parent_id')->default(0);
            $table->string('icon')->nullable();
            $table->string('uri');
            $table->tinyInteger('is_link')->default(0)->comment('0-no;1-yes');
            $table->string('permission_name', 50)->nullable();
            $table->string('guard_name', 30);
            $table->smallInteger('sequence')->default(0)->nullable();
            $table->boolean('is_display')->default(true);
            $table->string('description')->nullable();
            $table->nullableMorphs('cus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
