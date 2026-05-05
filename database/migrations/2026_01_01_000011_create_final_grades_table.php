<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained('internships')->onDelete('cascade');
            $table->foreignId('lecturer_id')->constrained('lecturers')->onDelete('restrict');
            $table->decimal('report_grade', 5, 2);
            $table->decimal('presentation_grade', 5, 2);
            $table->decimal('attitude_grade', 5, 2);
            $table->decimal('final_grade', 5, 2); // Calculated in app
            $table->text('notes')->nullable();
            $table->datetime('grading_date');
            $table->timestamps();
            $table->softDeletes();
            
            // Constraint: one grade record per internship
            $table->unique('internship_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_grades');
    }
};