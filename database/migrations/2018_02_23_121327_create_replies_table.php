<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('replies')) {
          Schema::create('replies', function (Blueprint $table) {
              $table->increments('id');
              $table->text('body');
              $table->boolean('is_hidden');
              $table->integer('comment_id')->unsigned()->index();
              $table->integer('user_id')->unsigned()->index();
              $table->timestamps();
          });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
