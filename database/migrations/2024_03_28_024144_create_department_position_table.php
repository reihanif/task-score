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
        Schema::create('department_position', function (Blueprint $table) {
            $table->foreignUuid('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreignUuid('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->timestamp('added_at')->nullable();
            $table->foreignUuid('adder_id')->nullable()->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_position');
    }
};
