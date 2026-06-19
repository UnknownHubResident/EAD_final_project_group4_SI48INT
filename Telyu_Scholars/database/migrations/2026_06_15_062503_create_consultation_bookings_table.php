<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultation_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The Student
            $table->foreignId('mentor_id')->constrained()->onDelete('cascade'); // The Mentor
            $table->date('booking_date');
            $table->time('booking_time'); // Optimized: Changed from string to time for native database operations
            $table->text('notes')->nullable();
            $table->string('status')->default('Pending'); // Fixed: Capitalized 'Pending' to natively match your UI dashboard logic
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultation_bookings');
    }
};