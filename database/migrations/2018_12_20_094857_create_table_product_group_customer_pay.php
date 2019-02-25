<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductGroupCustomerPay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_customer_group_pay_cent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_customer_group');
            $table->string('supply');
            $table->integer('pay');
            $table->integer('pay_make');
            $table->integer('id_product');
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
}
