<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->float('price', 8, 2)->default(0.00);
            $table->string('category');
            $table->string('description');
            $table->string('photo');

            $table->unsignedBigInteger('fk_base', false)->nullable()->index();
            $table->unsignedBigInteger('fk_break', false)->nullable()->index();
            $table->unsignedBigInteger('fk_saddle', false)->nullable()->index();
            $table->unsignedBigInteger('fk_tyres', false)->nullable()->index();
            $table->unsignedBigInteger('fk_acc', false)->nullable()->index();

            $table->foreign('fk_base')->references('id')->on('bases')->onDelete('set null');
            $table->foreign('fk_break')->references('id')->on('brakes')->onDelete('set null');
            $table->foreign('fk_saddle')->references('id')->on('saddles')->onDelete('set null');
            $table->foreign('fk_tyres')->references('id')->on('tyres')->onDelete('set null');
            $table->foreign('fk_acc')->references('id')->on('accessories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
