<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // 1. Foreign Keys (Who is applying for what?)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');

            // 2. Academic Details (Your fields)
            $table->string('student_number');
            $table->string('study_major');
            $table->string('year_batch');
            $table->string('degree_rank');
            
            // 3. Status & Feedback
            // We use 'pending' as default so admin can review it.
            $table->string('status')->default('pending'); 
            $table->text('remarks')->nullable(); // Replaces 'rejection_reason'

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};