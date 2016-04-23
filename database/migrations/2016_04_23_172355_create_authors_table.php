<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            # The rest of the fields...
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('birth_year');
            $table->string('bio_url');

        });
    }

    public function down()
    {
        Schema::drop('authors');
    }
}
