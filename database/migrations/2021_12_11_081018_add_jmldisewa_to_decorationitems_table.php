<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJmldisewaToDecorationitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('decorationitems', function (Blueprint $table) {
            $table->unsignedInteger('jmldisewa')->after('stok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('decorationitems', function (Blueprint $table) {
            $table->dropColumn('jmldisewa');
        });
    }
}
