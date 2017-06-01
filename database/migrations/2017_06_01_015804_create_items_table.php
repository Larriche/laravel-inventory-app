<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->integer('vendor_id')->unsigned();
            $table->integer('type_id')->unsigned()->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('weight', 10, 2);
            $table->string('serial_number');
            $table->string('color');
            $table->date('release_date');
            $table->string('image_url');
            $table->string('tags');
            $table->timestamps();

            $table->foreign('vendor_id')
                  ->references('id')
                  ->on('vendors')
                  ->onDelete('cascade');

            $table->foreign('type_id')
                  ->references('id')
                  ->on('types')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
