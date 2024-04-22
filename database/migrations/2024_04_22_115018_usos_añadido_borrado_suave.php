<?php

use App\Models\Application;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('applications', Application::DELETED_AT)) {
            Schema::table('applications', function (Blueprint $table) {
                $table->softDeletes(Application::DELETED_AT);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('applications', Application::DELETED_AT)) {
            Schema::table('applications', function (Blueprint $table) {
                $table->dropColumn(Application::DELETED_AT);
            });
        }
    }
};
