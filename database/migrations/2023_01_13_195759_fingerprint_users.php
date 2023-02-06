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
        Schema::create('fingerprint_users', function (Blueprint $table) {
            $table->bigIncrements('id_fingerprint_user');    
            $table->string('name', 50);
            $table->string('fingerprint_code', 100);
            $table->string('state', 20);

            $table->unsignedBigInteger('id_fingerprint_sensor');
            $table->timestamps();

            
            $table->foreign('id_fingerprint_sensor')
                ->references('id_fingerprint_sensor')->on('fingerprint_sensors')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
        });


        Schema::create('fingerprint_entries', function (Blueprint $table) {
            $table->bigIncrements('id_fingerprint_entry');
            
            $table->unsignedBigInteger('id_fingerprint_user');
            $table->timestamps();

            
            $table->foreign('id_fingerprint_user')
                ->references('id_fingerprint_user')->on('fingerprint_users')
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
