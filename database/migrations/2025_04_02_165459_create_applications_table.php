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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('application_date');
            $table->string('application_status');
            $table->string('required_device_type');
            $table->integer('quantity_requested');
            $table->text('purpose');
            $table->string('urgency_level');
            $table->string('status')->default('pending');
            $table->string('approval_date')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->string('application_letter_pdf')->nullable();
            $table->string('application_letter_filename')->nullable();
            $table->integer('application_letter_size')->nullable();
            $table->string('application_letter_hash')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};