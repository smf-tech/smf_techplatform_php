<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleJuris extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_jurisdictions', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('jurisdiction_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jurisdiction_id')->references('id')->on('jurisdictions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['role_id', 'jurisdiction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_jurisdictions');   
    }
}
