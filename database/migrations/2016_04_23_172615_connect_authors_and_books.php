<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConnectAuthorsAndBooks extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {

            # Add a new INT field called `author_id` that has to be unsigned (i.e. positive)
            $table->integer('author_id')->unsigned();

            # This field `author_id` is a foreign key that connects to the `id` field in the `authors` table
            $table->foreign('author_id')->references('id')->on('authors');

        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {

            # ref: http://laravel.com/docs/migrations#dropping-indexes
            # combine tablename + fk field name + the word "foreign"
            $table->dropForeign('books_author_id_foreign');

            $table->dropColumn('author_id');
        });
    }
}