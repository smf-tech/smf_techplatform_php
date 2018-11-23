<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllJurisdictionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('districtName')->unique();
            $table->integer('state_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('state_id')->references('id')->on('states')
                ->onUpdate('cascade')->onDelete('cascade');

            // $table->primary(['state_id']);
        });

        Schema::create('talukas', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('talukaName')->unique();
            $table->integer('state_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('state_id')->references('id')->on('states')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')
                ->onUpdate('cascade')->onDelete('cascade');

            // $table->primary(['state_id','district_id']);
        });

        
        Schema::create('clusters', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('clusterName')->unique();
            $table->integer('state_id')->unsigned();
            $table->integer('district_id')->unsigned();            
            $table->integer('taluka_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('state_id')->references('id')->on('states')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('taluka_id')->references('id')->on('talukas')
                    ->onUpdate('cascade')->onDelete('cascade');

            // $table->primary(['state_id','district_id','taluka_id']);
        });

        
        Schema::create('villages', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('villageName')->unique();
            $table->integer('state_id')->unsigned();
            $table->integer('district_id')->unsigned();        
            $table->integer('taluka_id')->unsigned();
            $table->integer('cluster_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('state_id')->references('id')->on('states')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('taluka_id')->references('id')->on('talukas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cluster_id')->references('id')->on('clusters')
                ->onUpdate('cascade')->onDelete('cascade');

            // $table->primary(['state_id','district_id','taluka_id','cluster_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('districts');
        Schema::drop('talukas');
        Schema::drop('clusters');
        Schema::drop('villages');   
    }
}
