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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id_product');
            $table->string('name',200);
            $table->string('barcode',100)->unique();
            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_subcategory');
            $table->unsignedBigInteger('id_segment');
            $table->integer('stock');
            $table->double('price_bought',8,2);
            $table->double('price_sale',8,2);
            $table->double('discount',8,2);
            $table->timestamps();

            $table->foreign('id_category')
                ->references('id_category')->on('categories')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');

            $table->foreign('id_subcategory')
                ->references('id_subcategory')->on('subcategories')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');

            $table->foreign('id_segment')
                ->references('id_segment')->on('segments')
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
