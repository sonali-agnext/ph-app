<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schemes', function (Blueprint $table) {
            $table->id();
            $table->foreign('scheme_subcategory_id')->references('id')->on('scheme_subcategories');
            $table->string('scheme_name');
            $table->longText('subsidy');
            $table->decimal('cost_norms', 5, 2);
            $table->longText('terms');
            $table->longText('detailed_description');
            $table->longText('videos');
            $table->longText('scheme_image');
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
        Schema::dropIfExists('schemes');
    }
}
