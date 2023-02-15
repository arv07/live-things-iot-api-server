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
        Schema::create('device_sensors', function (Blueprint $table) {
            $table->bigIncrements('id_device_sensor');
            $table->string('sensors',20);
            $table->unsignedBigInteger('id_device');

            $table->foreign('id_device')
                ->references('id_device')->on('devices')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
            

            $table->timestamps();


        });


        Schema::create('fingerprint_sensors', function (Blueprint $table) {
            $table->bigIncrements('id_fingerprint_sensor');
            $table->string('reference',20);
            $table->unsignedBigInteger('id_device_sensor');
            $table->timestamps();

            $table->foreign('id_device_sensor')
                ->references('id_device_sensor')->on('device_sensors')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');


        });

        Schema::create('temperature_sensors', function (Blueprint $table) {
            $table->bigIncrements('id_temperature_sensor');
            $table->float('temperature',20);
            $table->unsignedBigInteger('id_device_sensor');
            $table->timestamps();
            $table->foreign('id_device_sensor')
                ->references('id_device_sensor')->on('device_sensors')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
        });

        Schema::create('magnetic_sensors', function (Blueprint $table) {
            $table->bigIncrements('id_magnetic_sensor');
            $table->smallInteger('state');
            $table->unsignedBigInteger('id_device_sensor');
            $table->timestamps();
            $table->foreign('id_device_sensor')
                ->references('id_device_sensor')->on('device_sensors')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
        });

        Schema::create('rfid_sensors', function (Blueprint $table) {
            $table->bigIncrements('id_rfid_sensor');
            $table->string('version',20);
            $table->smallInteger('state');
            $table->unsignedBigInteger('id_device_sensor');
            $table->timestamps();
            $table->foreign('id_device_sensor')
                ->references('id_device_sensor')->on('device_sensors')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
        });

        Schema::create('movement_sensors', function (Blueprint $table) {
            $table->bigIncrements('id_movement_sensor');
            $table->smallInteger('state');
            $table->unsignedBigInteger('id_device_sensor');
            $table->timestamps();
            $table->foreign('id_device_sensor')
                ->references('id_device_sensor')->on('device_sensors')
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
