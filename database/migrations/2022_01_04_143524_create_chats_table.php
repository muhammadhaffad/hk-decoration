<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->foreignId('from');
            $table->foreign('from')->references('id')->on('users')->onDelete('cascade');

            $table->foreignId('to');
            $table->foreign('to')->references('id')->on('users')->onDelete('cascade');
            
            $table->string('orderable_type')->nullable();
            $table->integer('orderable_id')->nullable();
            $table->text('pesan');
            $table->string('status');

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
        Schema::dropIfExists('chats');
    }
}
