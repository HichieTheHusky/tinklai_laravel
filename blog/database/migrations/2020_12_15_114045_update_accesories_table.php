<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAccesoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accessories', function (Blueprint $table) {
            $table -> dropColumn('size');
            $table -> dropColumn('material');
            $table->string('type');
            $table->string('materials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accessories', function (Blueprint $table) {
            $table->string('size');
            $table->float('material', 8, 2)->default(0.00);
            $table -> dropColumn('type');
            $table -> dropColumn('Materials');
        });
    }
}
