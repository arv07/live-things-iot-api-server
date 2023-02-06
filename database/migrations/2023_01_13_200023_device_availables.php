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
        Schema::create('devices_availables', function (Blueprint $table) {
            $table->bigIncrements('id_device_available');
            $table->string('name',50);
            $table->string('internal_code',100)->unique();
            $table->string('reference',50);
            $table->string('version',50);
            $table->timestamps();
           
        });

        Schema::create('sensors_availables', function (Blueprint $table) {
            $table->bigIncrements('id_sensor_available');
            $table->string('sensor',100);
            $table->string('reference');
            $table->timestamps();
           
        });

        Schema::create('devices_availables_sensors', function (Blueprint $table) {
            $table->bigIncrements('id_device_available_sensor');
            $table->unsignedBigInteger('id_device_available');
            $table->unsignedBigInteger('id_sensor_available');
            $table->timestamps();

            $table->foreign('id_device_available')
                ->references('id_device_available')->on('devices_availables')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');

            $table->foreign('id_sensor_available')
                ->references('id_sensor_available')->on('sensors_availables')
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
