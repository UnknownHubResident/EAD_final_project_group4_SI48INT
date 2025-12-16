<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

           
            $table->string('student_number')->unique()->nullable();
            $table->string('study_major')->nullable();
            $table->enum('degree_rank', ['Bachelor', 'Master', 'PhD'])->nullable();
            $table->string('year_batch', 4)->nullable();

            $table->enum('role',['admin','student','scholar_provider'])->default('student');
            $table->boolean('is_approved')->default(true); 
            $table->boolean('is_rejected')->default(false);
            $table->text('rejection_reason')->nullable();

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};