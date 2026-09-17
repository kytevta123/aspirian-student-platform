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
        Schema::create('practical_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practical_id')->constrained('practicals')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('attempt_number')->default(1);
            $table->string('status')->default('in_progress'); // in_progress, submitted, under_review, completed, requires_revision
            $table->timestamp('safety_acknowledged_at')->nullable();
            $table->text('report_text')->nullable(); // objective, procedure, observations, conclusion
            $table->string('media_path')->nullable(); // image, video, code file, pdf, etc.
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practical_submissions');
    }
};