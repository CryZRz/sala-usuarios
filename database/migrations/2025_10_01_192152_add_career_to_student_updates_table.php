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
            $table->foreignId("career_id")->constrained();
            $table->dropColumn("career");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_updates', function (Blueprint $table) {
            $table->dropforeign("career_id");
            $table->dropColumn("career_id");
        });
    }
};
