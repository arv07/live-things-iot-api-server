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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id_category');
            $table->string('category',100);
            $table->timestamps();
                        
        });


        Schema::create('subcategories', function (Blueprint $table) {
            $table->bigIncrements('id_subcategory');
            $table->string('subcategory',100);
            $table->timestamps();
                        
        });


        Schema::create('segments', function (Blueprint $table) {
            $table->bigIncrements('id_segment');
            $table->string('segment',100);
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
        //
    }
};
