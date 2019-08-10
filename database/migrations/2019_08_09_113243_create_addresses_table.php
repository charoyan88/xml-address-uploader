<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('addresses_id');
            $table->string('addresses_address');
            $table->string('addresses_street');
            $table->string('addresses_street_name');
            $table->string('addresses_street_type');
            $table->string('addresses_adm');
            $table->string('addresses_adm1');
            $table->string('addresses_adm2');
            $table->string('addresses_cord_x');
            $table->string('addresses_cord_y');
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
        Schema::dropIfExists('addresses');
    }
}
