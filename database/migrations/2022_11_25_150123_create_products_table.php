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
            $table->string('entry')->nullable();
            $table->timestamp('date')->nullable();
            $table->string('name')->nullable();
            $table->string('sale_order')->nullable();
            $table->unsignedBigInteger('main_category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('season_id')->nullable();
            $table->unsignedBigInteger('age_group_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('loom_type_id')->nullable();
            $table->string('greige_quality')->nullable();
            $table->string('composition')->nullable();
            $table->string('finish_fabric_quality')->nullable();
            $table->string('gsm')->nullable();
            $table->string('process')->nullable();
            $table->unsignedBigInteger('atribute_yarn_id')->nullable();
            $table->unsignedBigInteger('atribute_weaving_id')->nullable();
            $table->unsignedBigInteger('atribute_processing_id')->nullable();
            $table->unsignedBigInteger('atribute_stitching_id')->nullable();
            $table->unsignedBigInteger('fabric_type_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('gallery')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('main_category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('sub_category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('restrict');
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('restrict');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('loom_type_id')->references('id')->on('loom_types')->onDelete('restrict');
            $table->foreign('atribute_yarn_id')->references('id')->on('atribute_yarns')->onDelete('restrict');
            $table->foreign('atribute_weaving_id')->references('id')->on('atribute_weavings')->onDelete('restrict');
            $table->foreign('atribute_processing_id')->references('id')->on('atribute_processings')->onDelete('restrict');
            $table->foreign('atribute_stitching_id')->references('id')->on('atribute_stitchings')->onDelete('restrict');
            $table->foreign('fabric_type_id')->references('id')->on('fabric_types')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('products');
    }
}
