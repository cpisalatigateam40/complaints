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
        Schema::table('corrective_actions', function (Blueprint $table) {
            $table->longText('short_term_ca')->nullable()->change();
            $table->longText('long_term_ca')->nullable()->change();
            $table->longText('causative_factor')->nullable()->change();
            // complaint_uuid remains NOT NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corrective_actions', function (Blueprint $table) {
            $table->longText('short_term_ca')->nullable(false)->change();
            $table->longText('long_term_ca')->nullable(false)->change();
            $table->longText('causative_factor')->nullable(false)->change();
        });
    }
};
