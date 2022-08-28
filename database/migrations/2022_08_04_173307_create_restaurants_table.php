<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
            $table->string('email');
			$table->string('phone');
			$table->text('description');
            $table->string('password');
            $table->string('minimum_order');
			$table->string('mobile_communication');
			$table->string('Image');
            $table->string('delivery');
			$table->string('whatsapp');
			$table->enum('status', array('open', 'closed'));
            $table->string('api_token',60)->unique()->nullable();
            $table->string('pin_code')->nullable();
			$table->string('notification_token',60)->unique()->nullable();
			// $table->integer('city_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->integer('category_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
