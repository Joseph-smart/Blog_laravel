<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('cate_id')->default(null)->nullable(true)->comment('分类id');
            $table->string('title', 255)->default(null)->comment('标题');
            $table->string('tag', 255)->default(null)->nullable(true)->comment('标签');
            $table->string('description', 255)->default(null)->comment('描述');
            $table->string('cover', 255)->default(null)->nullable(true)->comment('封面');
            $table->text('content')->default(null)->comment('正文');
            $table->integer('view')->default(0)->comment('阅读数');
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
        Schema::dropIfExists('article');
    }
}
