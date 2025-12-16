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
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');

            $table->enum('status', ['applied', 'pending', 'accepted', 'rejected'])->default('applied');

            $table->string('student_number')->nullable();
            $table->string('study_major')->nullable();
            $table->string('year_batch')->nullable();
            $table->string('degree_rank')->nullable(); 
            
            $table->text('motivation_letter')->nullable();
            $table->string('transcript_path')->nullable(); 
            $table->string('student_id_path')->nullable();

            $table->text('rejection_reason')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};
