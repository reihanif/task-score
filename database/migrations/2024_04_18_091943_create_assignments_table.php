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
        Schema::create('assignments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('parent_id')->nullable()->references('id')->on('assignments')->onDelete('cascade');
            $table->foreignUuid('taskmaster_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('assigned_to')->references('id')->on('users')->onDelete('cascade');
            $table->string('type');
            $table->string('subject');
            $table->text('description');
            $table->datetime('due');
            $table->datetime('resolved_at');
            $table->enum('status', array('open','closed'))->default('open');
            $table->datetime('closed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
