<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('claimant_name')->nullable()->after('description');
            $table->string('claimant_email')->nullable()->after('claimant_name');
            $table->string('claimant_phone', 20)->nullable()->after('claimant_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn(['claimant_name', 'claimant_email', 'claimant_phone']);
        });
    }
};
