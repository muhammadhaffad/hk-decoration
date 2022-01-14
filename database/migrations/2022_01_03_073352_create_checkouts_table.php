<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('items');
            $table->string('nama');
            $table->string('notlp');
            $table->date('tglsewa');
            $table->date('tglbongkar');
            $table->integer('ongkir');
            $table->integer('biayaongkir');
            $table->string('alamat');
            $table->string('bayar');
            $table->string('waktuPelunasan')->nullable();
            $table->integer('lamaSewa');
            $table->string('hargaSewa');
            $table->integer('total');

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
        Schema::dropIfExists('checkouts');
    }
}
