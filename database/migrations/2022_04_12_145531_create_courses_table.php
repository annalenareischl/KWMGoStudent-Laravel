<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
  {
      Schema::create('courses', function (Blueprint $table) {
          $table->id(); //primarykey
          $table->string('cID')->unique();
          $table->string('title');
          $table->integer('semester')->nullable();
          $table->text('description')->nullable();
          $table->text('comment')->nullable();
           //FK
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('courses');
    }
}
