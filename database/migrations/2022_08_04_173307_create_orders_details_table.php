<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersDetailsTable extends Migration {

	public function up()
	{
		Schema::create('orders_details', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('order_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->integer('quantity');
			$table->decimal('price');
			$table->string('additions');
			$table->integer('deliveryfee');
		});
	}

	public function down()
	{
		Schema::drop('orders_details');
	}
}
