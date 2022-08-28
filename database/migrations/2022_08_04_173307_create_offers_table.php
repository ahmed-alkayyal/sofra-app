<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
			$table->string('offer');
			$table->string('img');
			$table->text('description');
			$table->datetime('time_from');
			$table->datetime('time_to');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
