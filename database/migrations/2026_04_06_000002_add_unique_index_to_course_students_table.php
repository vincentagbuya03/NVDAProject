<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove existing duplicate rows before applying the unique index.
        DB::statement('DELETE cs1 FROM course_students cs1 INNER JOIN course_students cs2 WHERE cs1.id > cs2.id AND cs1.student_id = cs2.student_id AND cs1.course_id = cs2.course_id');

        Schema::table('course_students', function (Blueprint $table) {
            $table->unique(['student_id', 'course_id'], 'course_students_student_course_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_students', function (Blueprint $table) {
            // Drop foreign keys first before dropping the unique index
            $table->dropForeign(['course_id']);
            $table->dropForeign(['student_id']);
        });

        Schema::table('course_students', function (Blueprint $table) {
            $table->dropUnique('course_students_student_course_unique');
        });

        // Recreate the foreign keys without the unique constraint
        Schema::table('course_students', function (Blueprint $table) {
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }
};
