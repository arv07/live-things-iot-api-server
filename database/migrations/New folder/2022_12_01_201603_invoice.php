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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id_invoice');
            $table->string('code_invoice',100)->unique();
            $table->unsignedBigInteger('id_customer');
            $table->double('discount',8,2);
            $table->double('total_sale',8,2);
            $table->string('state',20);
            $table->timestamps();

            $table->foreign('id_customer')
                ->references('id_customer')->on('customers')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');
                        
        });


        Schema::create('invoice_details', function (Blueprint $table) {
            $table->bigIncrements('id_invoice_detail');
            $table->unsignedBigInteger('id_invoice');
            $table->unsignedBigInteger('id_product');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('id_invoice')
                ->references('id_invoice')->on('invoices')
                ->onDelete('cascade')
                ->onUpdateCascade('cascade');

            $table->foreign('id_product')
                ->references('id_product')->on('products')
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
