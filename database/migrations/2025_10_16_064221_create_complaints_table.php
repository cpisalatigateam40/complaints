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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->date('date');
            $table->date('product_arrival_date')->nullable();
            $table->string('product_name');
            $table->string('production_code')->nullable();
            $table->date('best_before')->nullable();
            $table->integer('complaint_amount');
            $table->text('nonconformity_type');
            $table->string('ncr')->nullable();
            $table->string('complaint_documentation');
            $table->string('customer');
            $table->uuid('plant_uuid');
            $table->string('delivery');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('plant_uuid')->references('uuid')->on('plants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
