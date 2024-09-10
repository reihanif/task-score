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
        Schema::table('time_extensions', function (Blueprint $table) {
            // Drop only the foreign key constraint (not the column)
            $table->dropForeign(['task_id']);

            // Re-add the foreign key with onDelete('cascade'), keeping the data intact
            $table->foreign('task_id')
                  ->references('id')->on('tasks')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_extensions', function (Blueprint $table) {
            // Drop the cascade foreign key
            $table->dropForeign(['task_id']);

            // Re-add the original foreign key without cascade
            $table->foreign('task_id')
                  ->references('id')->on('tasks');
        });
    }
};
