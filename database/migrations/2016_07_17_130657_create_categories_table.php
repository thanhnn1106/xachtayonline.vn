<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name');
            $table->string('category_name_en');
            $table->string('category_slug');
            $table->string('category_slug_en');
            $table->integer('category_id');

            $table->string('fa_icon');
            $table->string('color_class');
            $table->string('description');
            $table->string('description_en');
            $table->boolean('is_active');

            $table->integer('product_count');
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
        Schema::drop('categories');
    }
}
