<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('pages')) {
          Schema::create('pages', function (Blueprint $table) {
              $table->increments('id');
              $table->string('title');
              $table->string('page_content');
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
        Schema::dropIfExists('pages');
    }
}
