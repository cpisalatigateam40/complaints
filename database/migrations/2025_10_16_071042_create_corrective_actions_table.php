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
        Schema::create('corrective_actions', function (Blueprint $table) {
            $table->id();
            $table->longText('short_term_ca');
            $table->longText('long_term_ca');
            $table->longText('causative_factor');
            $table->uuid('complaint_uuid');
            $table->timestamps();

            $table->foreign('complaint_uuid')->references('uuid')->on('complaints');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corrective_actions');
    }
};
