<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('year')->nullable();
            $table->string('genre')->nullable();
            $table->string('stars')->nullable();
            $table->string('poster')->nullable();
            $table->string('rating')->nullable();
            $table->string('runtime')->nullable();
            $table->string('director')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['title', 'year', 'director']);

        });

        // Pivot tabel.
        Schema::create('movie_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('seen');
            $table->timestamps();

            $table->unique(['movie_id', 'user_id']);

            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
