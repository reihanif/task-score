<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            // Add the new creator_id column, which will reference the users table
            $table->foreignUuid('creator_id')->nullable()->after('closed_at');
        });

        // Populate the creator_id column with the old taskmaster_id (user id)
        DB::table('assignments')
            ->update([
                'creator_id' => DB::raw('taskmaster_id')
            ]);

        // Temporarily drop the foreign key constraint on taskmaster_id
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['taskmaster_id']);
        });

        // Update taskmaster_id to reference the position instead of the user
        DB::table('assignments')
            ->join('users', 'assignments.taskmaster_id', '=', 'users.id')
            ->join('positions', 'users.position_id', '=', 'positions.id')
            ->update([
                'assignments.taskmaster_id' => DB::raw('users.position_id')
            ]);

        // Recreate the foreign key for taskmaster_id referencing the positions table
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('taskmaster_id')
                ->references('id')
                ->on('positions')
                ->onDelete('cascade');

            // Add the foreign key for creator_id, referencing the users table
            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys for creator_id and taskmaster_id
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
            $table->dropForeign(['taskmaster_id']);
        });

        // Restore taskmaster_id back to its original user id
        DB::table('assignments')
            ->join('users', 'users.position_id', '=', 'assignments.taskmaster_id')
            ->update([
                'assignments.taskmaster_id' => DB::raw('users.id')
            ]);

        // Drop the creator_id column
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropColumn('creator_id');
        });

        // Recreate the foreign key for taskmaster_id referencing the users table
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreign('taskmaster_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
