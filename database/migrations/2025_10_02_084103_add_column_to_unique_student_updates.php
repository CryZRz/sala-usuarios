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
        Schema::table('student_updates', function (Blueprint $table) {
            $table->dropUnique('actualizacion_unica');

            $table->unique(
                ['controlNumber', 'career_id', 'semester', 'period_id', "active"],
                'unique_student_update'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasIndex('unique_student_update', 'unique_student_update')) {
            Schema::table('student_updates', function (Blueprint $table) {
                $table->dropUnique('unique_student_update');
            });
        }
    }
};
