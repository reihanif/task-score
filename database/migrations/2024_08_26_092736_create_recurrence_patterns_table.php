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
        Schema::create('recurrence_patterns', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->enum('recurrence_type', ['daily', 'weekly', 'monthly']);
            $table->integer('interval')->default(1);
            $table->json('day_of_week')->nullable();
            $table->integer('day_of_month')->nullable();
            $table->time('time');
            $table->date('recurrence_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurrence_patterns');
    }
};
