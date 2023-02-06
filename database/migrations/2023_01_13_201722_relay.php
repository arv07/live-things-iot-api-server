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
        Schema::create('relay_sensors', function (Blueprint $table) {
            $table->bigIncrements('id_relay');
            $table->boolean('state');
            $table->unsignedBigInteger('id_device_sensor');
            $table->timestamps();
            $table->foreign('id_device_sensor')
                ->references('id_device_sensor')->on('device_sensors')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
            
           
        });

        Schema::create('relay_alarms', function (Blueprint $table) {
            $table->bigIncrements('id_alarm');
            $table->string('name',15);
            $table->boolean('state');//Active or Inactive
            $table->boolean('action');//Turn on or off
            $table->boolean('repeat');
            $table->smallInteger('hour');
            $table->smallInteger('minute');
            $table->boolean('monday');
            $table->boolean('tuesday');
            $table->boolean('wednesday');
            $table->boolean('thursday');
            $table->boolean('friday');
            $table->boolean('saturday');
            $table->boolean('sunday');
            $table->unsignedBigInteger('id_relay');
            $table->timestamps();
            $table->foreign('id_relay')
                ->references('id_relay')->on('relay_sensors')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
            
           
        });


        Schema::create('relay_events', function (Blueprint $table) {
            $table->bigIncrements('id_relay_event');
            $table->boolean('state');
            $table->unsignedBigInteger('id_relay');
            $table->timestamps();
            $table->foreign('id_relay')
                ->references('id_relay')->on('relay_sensors')
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
