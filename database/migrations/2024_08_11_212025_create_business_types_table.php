<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('visible')->default(false);
            $table->timestamps();
        });

        // Insert default business types
        DB::table('business_types')->insert([
            ['id'=>1,'name' => 'ADMIN'],
            ['id'=>2,'name' => 'ADMIN BUSSINESS'],
            ['id'=>3,'name' => 'TIENDA'],
            ['id'=>4,'name' => 'RESTAURANTE'],
            ['id'=>5,'name' => 'SERVICIOS'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_types');
    }
}
