<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_relationships', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('relation_id');
            $table->foreign('relation_id')->references('id')->on('relationships');

            $table->unsignedBigInteger('person_id');
            $table->string('person_type');
            $table->foreign('person_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_relationships');
    }
};
