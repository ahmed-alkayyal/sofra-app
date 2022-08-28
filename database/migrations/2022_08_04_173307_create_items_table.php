<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration {

	public function up()
	{
		Schema::create('items', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->text('description');
			$table->string('image');
			$table->integer('restaurant_id')->unsigned();
			$table->decimal('price');
			$table->decimal('offer_price');
			$table->string('order_time')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('items');
	}
}
