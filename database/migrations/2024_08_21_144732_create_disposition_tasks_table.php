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
        Schema::create('disposition_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('disposition_id')->references('id')->on('dispositions')->onDelete('cascade');
            $table->foreignUuid('assignee_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('task', ['action', 'review', 'info', 'file']);
            $table->enum('status', ['pending', 'delegated', 'resolved'])->default('pending');
            $table->text('detail')->nullable();
            $table->datetime('due_date')->nullable();
            $table->foreignUuid('parent_task_id')->nullable()->references('id')->on('disposition_tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposition_tasks');
    }
};