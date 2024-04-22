<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Incidence;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('incidences')) {
            Schema::create('incidences', function (Blueprint $table) {
                $table->id();
                $table->foreignId("student_update_id")->constrained()->onDelete("cascade");
                $table->foreignId("user_id")->constrained()->onDelete("cascade");
                $table->string("descripción");
                $table->string("estatus");
                $table->timestamp(Incidence::CREATED_AT)->nullable();
                $table->timestamp(Incidence::UPDATED_AT)->nullable();
                $table->softDeletes(Incidence::DELETED_AT);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidences');
    }
};
