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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->constrained()->onDelete("cascade");
            $table->foreignId("computer_id")->constrained()->onDelete("cascade");
            $table->foreignId("application_id")->constrained()->onDelete("cascade");
            $table->boolean("status");
            $table->time("timeAssigment");
            $table->dateTime("startTime");
            $table->dateTime("endTime")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
