<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id_device');
            $table->string('name',100);
            $table->string('version',20);
            $table->string('description',50)->nullable($value = true);
            $table->string('location',50)->nullable($value = true);
            $table->string('state', 20);
            $table->string('device_token', 100)->unique();
            $table->string('id_socket', 100);
            $table->string('internal_code', 100);
            $table->string('reference',50);
            $table->timestamps();

            //$table->unsignedBigInteger('id_device_type');
            $table->unsignedBigInteger('id_user');
            
            /* $table->foreign('id_device_type')
                ->references('id_device_type')->on('device_types')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade'); */

            $table->foreign('id_user')
                ->references('id_user')->on('users')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
