<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Degree;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('degree_id')->nullable()->constrained('degrees')->onDelete('set null');
            $table->dropColumn('course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::statement('ALTER TABLE `students` DROP FOREIGN KEY `students_degree_id_foreign`');
            $table->dropColumn('degree_id');
            $table->string('course')->nullable();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        });
    }
};
