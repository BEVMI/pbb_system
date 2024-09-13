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
        Schema::create('pallet_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status_name'); 
            $table->boolean('is_reason');
            $table->boolean('is_quarantine');
            $table->boolean('is_approved');
            $table->boolean('is_on_hold');
            $table->boolean('is_reject');
            $table->boolean('is_turnover');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallet_statuses');
    }
};
