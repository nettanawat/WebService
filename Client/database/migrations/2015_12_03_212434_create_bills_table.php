<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->unique();
            $table->string('phone_number', 45)->unique();
            $table->string('email', 45)->unique();
            $table->string('line1', 100)->nullable();
            $table->string('district', 45)->nullable();
            $table->string('province', 45)->nullable();
            $table->string('post_code', 5)->nullable();
            $table->string('product_name');
            $table->integer('product_amount');
            $table->double('total_price');
            $table->integer('is_paid');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('server_order_id')->on('orders');
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
        Schema::drop('bills');
    }
}
