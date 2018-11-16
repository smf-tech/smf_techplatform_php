<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StateJuris extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stateName')->unique();
            $table->timestamps();
        });
        Schema::create('jurisdictions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('levelName')->nullable();
            $table->timestamps();
        });
        Schema::create('state_jurisdictions', function (Blueprint $table) {
            $table->integer('state_id')->unsigned();
            $table->integer('jurisdiction_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('state_id')->references('id')->on('states')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jurisdiction_id')->references('id')->on('jurisdictions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['state_id', 'jurisdiction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('states');
        Schema::drop('jurisdiction');   
        Schema::drop('state_jurisdictions');   
    }
}
