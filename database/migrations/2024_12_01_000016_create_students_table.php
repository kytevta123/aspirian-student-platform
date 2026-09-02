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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->unsignedBigInteger('current_grade_id')->nullable();
            $table->unsignedBigInteger('current_board_id')->nullable();
            $table->unsignedBigInteger('current_academic_session_id')->nullable();
            $table->string('status')->default('active')->index();
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('current_grade_id')
                ->references('id')
                ->on('grades')
                ->onDelete('set null');
            
            $table->foreign('current_board_id')
                ->references('id')
                ->on('boards')
                ->onDelete('set null');
            
            $table->foreign('current_academic_session_id')
                ->references('id')
                ->on('academic_sessions')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
