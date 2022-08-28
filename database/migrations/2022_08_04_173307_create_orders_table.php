<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
            $table->integer('restaurant_id')->unsigned();
			$table->decimal('total_price');
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered', 'decliened'));
			$table->string('address');
			$table->decimal('total');
			$table->decimal('delivery_price');
			$table->decimal('site_commission');
            $table->enum('payingoff', array('Cash', 'online'));
			$table->text('note');
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
