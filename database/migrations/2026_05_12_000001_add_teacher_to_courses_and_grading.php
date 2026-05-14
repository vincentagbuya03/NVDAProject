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
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->after('id')->constrained('teachers')->onDelete('set null');
        });

        Schema::table('course_students', function (Blueprint $table) {
            $table->string('grade')->nullable()->after('student_id');
            $table->string('status')->default('enrolled')->after('grade'); // enrolled, completed, dropped
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });

        Schema::table('course_students', function (Blueprint $table) {
            $table->dropColumn(['grade', 'status']);
        });
    }
};
