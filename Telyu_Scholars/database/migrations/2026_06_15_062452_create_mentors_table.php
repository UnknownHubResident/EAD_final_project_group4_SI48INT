<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->id(); // Or use $table->id('site_id'); if aligning with your custom pattern
            $table->string('name');
            $table->string('platform'); // online, onsite, onsite and online
            $table->string('location'); // Jakarta, Bandung, Surabaya, Purwokerto
            $table->string('working_days'); // everyday, weekdays only, etc.
            $table->string('time_schedule'); // e.g., "08:30 - 16:30"
            $table->text('specialty');
            $table->string('profile_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentors');
    }
};