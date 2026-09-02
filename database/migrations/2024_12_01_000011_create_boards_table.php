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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('education_system_id');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('status')->default('active')->index();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('education_system_id')
                ->references('id')
                ->on('education_systems')
                ->onDelete('cascade');
            
            $table->index(['education_system_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
