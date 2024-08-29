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
        Schema::create('delete_disposition_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('disposition_id')->references('id')->on('dispositions')->onDelete('cascade');
            $table->string('reason');
            $table->foreignUuid('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'rejected', 'accepted']);
            $table->dateTime("decision_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delete_disposition_requests');
    }
};