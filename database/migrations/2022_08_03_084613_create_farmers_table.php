<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->foreign('applicant_type_id')->references('id')->on('applicant_types');            
            $table->string('name');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('mobile_number')->unique();
            $table->string('father_husband_name');
            $table->string('gender');
            $table->string('resident');
            $table->string('aadhar_number');
            $table->string('pan_number');
            $table->foreign('caste_category_id')->references('id')->on('caste_categories');
            $table->string('state');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('tehsil_id')->references('id')->on('tehsils');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('full_address');
            $table->string('farmer_unique_id');
            $table->string('pin_code');
            $table->string('avatar', 500)->nullable();
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
        Schema::dropIfExists('farmers');
    }
}
