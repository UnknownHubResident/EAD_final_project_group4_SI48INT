    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void 
        {

        Schema::table('users', function (Blueprint $table) {
            // Role definition
            $table->enum('role',['admin','student','scholar_provider'])->default('student')->after('email');
            
            
            $table->boolean('is_approved')->default(true)->after('role'); 

            $table->boolean('is_rejected')->default(false)->after('is_approved');

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
            $table->dropColumn('is_rejected');
        });
    }
};

