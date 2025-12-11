    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {

        Schema::table('users', function (Blueprint $table) {
            // Role definition
            $table->enum('role',['admin','student','scholar_provider'])->default('student')->after('email');
            
            // FIX: Moved 'is_approved' definition INSIDE the closure
            $table->boolean('is_approved')->default(true)->after('role'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('is_approved');
        });
    }
};

