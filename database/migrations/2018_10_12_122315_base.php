<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Base extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->charset('utf8');
            $table->json('params')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thread_id')->unsigned()->index();
            $table->integer('user_id')->unsigned();
            $table->string('content')->charset('utf8');
            $table->json('params')->nullable();
            $table->timestamps();

            $table->foreign('thread_id')
                ->references('id')->on('threads')
                ->onDelete('cascade');

            $table->index(['thread_id', 'created_at']);
        });

        Schema::create('user_threads', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('thread_id')->unsigned();

            $table->primary(['user_id', 'thread_id']);
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
        Schema::dropIfExists('messages');
        Schema::dropIfExists('threads');
    }
}
