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
        Schema::table('time_extensions', function (Blueprint $table) {
            $table->text('approval_detail')->nullable()->after('is_approve');
            $table->uuid('approver_id')->nullable()->after('approval_detail');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('set null');
        });

        // Populate the approver_id based on the is_approve condition, assuming UUIDs
        DB::statement('
            UPDATE time_extensions
            JOIN tasks ON time_extensions.task_id = tasks.id
            JOIN assignments ON tasks.assignment_id = assignments.id
            SET time_extensions.approver_id = CASE
                WHEN time_extensions.is_approve IS NOT NULL THEN assignments.creator_id
                ELSE NULL
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_extensions', function (Blueprint $table) {
            $table->dropForeign(['approver_id']);
            $table->dropColumn('approver_id');
            $table->dropColumn('approval_detail');
        });
    }
};
