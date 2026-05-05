<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->onDelete('cascade');
            $table->integer('week_number')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('activity_description');
            $table->text('challenges')->nullable();
            $table->text('next_week_plan')->nullable();
            $table->enum('status', ['draft', 'submitted', 'validated'])->default('draft')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};