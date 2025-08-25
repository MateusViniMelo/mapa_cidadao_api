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
        Schema::table('ocurrences', function (Blueprint $table) {
            $table->enum('type_closure', ['resolved', 'mistake'])->nullable();
            $table->text('solution_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ocurrences', function (Blueprint $table) {
            $table->dropColumn(['type_closure', 'solution_description']);
        });
    }
};
