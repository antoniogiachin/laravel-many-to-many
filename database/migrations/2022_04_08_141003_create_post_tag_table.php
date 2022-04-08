<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            // rimuovo

            $table->unsignedBigInteger('post_id');
            // questo post_id  è una foreignkey che rappresenta l'id della tabella posts
            $table->foreign('post_id')->references('id')->on('posts');

            // stessa cosa per tag_id
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags');

            // indice coppia https://laravel.com/docs/7.x/migrations#indexes
            $table->index(['post_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
