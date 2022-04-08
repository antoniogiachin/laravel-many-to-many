<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //aggiungo foreign key, sarà nullable e anche dopo slug nella table
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');
            //collego le due table, 
            // dico che la category_id è un foreign
            $table->foreign('category_id')
            // che si riferisce all'id
            ->references('id')
            // della tabella
            ->on('categories')
            // alla cancellazione i post relativi vengono settati su category null
            ->onDelete('set null');

            //snippet per rendere tutto più corto, ci pensa laravel a completare
            // $table->foreignId('category_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //per prima cosa tolgo la relazione
            $table->dropForeign('posts_category_id_foreign');
            // drop della colonna
            $table->dropColumn('category_id');
        });
    }
}
