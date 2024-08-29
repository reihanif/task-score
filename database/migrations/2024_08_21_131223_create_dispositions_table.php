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
        Schema::create('dispositions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('no_agenda')->unique();
            $table->enum('status', ['pending', 'submitted', 'sent to sender', 'sent to presdir', 'closed'])->default('pending');
            $table->enum('sender_type', ['internal', 'external']);
            $table->foreignUuid('sender_id')->nullable()->references('id')->on('departments')->onDelete('cascade');
            $table->string('sender_name')->nullable();
            $table->date('date_of_letter');
            $table->date('date_of_letter_received');
            $table->string('subject');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent']);
            $table->datetime('due_date')->nullable();
            $table->foreignUuid('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositions');
    }
};