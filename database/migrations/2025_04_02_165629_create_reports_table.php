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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->date('report_month');
            $table->date('submission_date')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('total_devices')->nullable();
            $table->string('devices_in_use')->nullable();
            $table->string('devices_in_storage')->nullable();
            $table->string('devices_in_maintenance')->nullable();
            $table->string('usage_hours')->nullable();
            $table->string('issues_reported')->nullable();
            $table->string('educational_impact')->nullable();
            $table->string('challenges_faced')->nullable();
            $table->boolean('needs_additional_devices')->default(false);
            $table->string('verification_status')->default('pending');
            $table->string('verified_by')->nullable();
            $table->text('verification_notes')->nullable();
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};