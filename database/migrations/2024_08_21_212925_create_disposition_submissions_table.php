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
        Schema::create('disposition_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('disposition_task_id')->references('id')->on('disposition_tasks')->onDelete('cascade');
            $table->text('detail');
            $table->foreignUuid('decider_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->enum('decision', ['approve', 'reject']);
            $table->text('decision_detail')->nullable();
            $table->datetime('decision_at')->nullable();    
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposition_submissions');
    }
};