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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'student', 'scholar_provider'])->default('student')->after('email');
        $table->boolean('is_approved')->default(false)->after('role');
        $table->boolean('is_rejected')->default(false)->after('is_approved');
        $table->text('rejection_reason')->nullable()->after('is_rejected');
    });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['rejection_reason', 'is_rejected', 'is_approved', 'role']);
    });
    }

};