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
            $table->boolean('seen');
            $table->string('year')->nullable();
            $table->string('genre')->nullable();
            $table->string('stars')->nullable();
            $table->string('poster')->nullable();
            $table->string('rating')->nullable();
            $table->string('runtime')->nullable();
            $table->string('director')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('user_id'); // Foreign key to User.php, default foreign key is relation method with _id suffix.
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
        Schema::dropIfExists('movies');
    }
}
