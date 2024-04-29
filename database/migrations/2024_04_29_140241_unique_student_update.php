<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasIndex('student_updates', 'actualizacion_unica')) {
            Schema::table('student_updates', function (Blueprint $table) {
                $table->unique(
                    name: "actualizacion_unica",
                    columns: ['controlNumber', 'career', 'semester', 'period_id']
                );
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasIndex('student_updates', 'actualizacion_unica')) {
            Schema::table('student_updates', function (Blueprint $table) {
                $table->dropUnique('actualizacion_unica');
            });
        }
    }
};
