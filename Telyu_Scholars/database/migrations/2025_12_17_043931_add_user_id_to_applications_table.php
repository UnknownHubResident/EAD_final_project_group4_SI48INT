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

            // Foreign key to users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Foreign key to scholarships
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');

            // Optional remarks by admin
            $table->text('remarks')->nullable();

            // Status: pending, approved, rejected
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
