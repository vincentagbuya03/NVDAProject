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
        Schema::table('students', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->after('gender');
            $table->dropColumn('age');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->after('gender');
            $table->dropColumn('age');
            
            // Link degree to teacher (renaming/replacing course string with degree_id)
            $table->unsignedBigInteger('degree_id')->nullable()->after('birthdate');
            $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('set null');
            $table->dropColumn('course');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('degree_id')->nullable()->after('teacher_id');
            $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->integer('age')->after('gender')->nullable();
            $table->dropColumn('birthdate');
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->integer('age')->after('gender')->nullable();
            $table->string('course')->after('birthdate')->nullable();
            $table->dropColumn(['birthdate', 'degree_id']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['degree_id']);
            $table->dropColumn('degree_id');
        });
    }
};
