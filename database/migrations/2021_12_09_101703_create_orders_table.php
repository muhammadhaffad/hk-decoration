<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->string('kodeSewa')->index();
            $table->dateTime('tanggalTransaksi');
            $table->string('namaPenyewa');
            $table->string('alamatPenyewa');
            $table->string('noTlpPenyewa');
            $table->date('tanggalSewa');
            $table->date('tanggalBongkar');
            $table->date('tanggalKembali')->nullable();
            $table->string('jenis');
            $table->string('waktuPelunasan')->nullable();
            $table->integer('total');
            $table->integer('ongkir');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
