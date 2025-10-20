<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('brand');
            $table->string('product_name');
            $table->string('nett_weight')->nullable();
            $table->integer('shelf_life');
            $table->uuid('plant_uuid');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('plant_uuid')->on('plants')->references('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
