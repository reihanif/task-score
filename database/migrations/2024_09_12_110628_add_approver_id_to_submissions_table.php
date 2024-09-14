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
        Schema::table('submissions', function (Blueprint $table) {
            // Adding the approver_id column as UUID and nullable
            $table->uuid('approver_id')->nullable()->after('approval_detail');

            // If you're enforcing foreign key constraints (optional)
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('set null');
        });

        // Populate the approver_id based on the is_approve condition, assuming UUIDs
        DB::statement('
            UPDATE submissions
            JOIN tasks ON submissions.task_id = tasks.id
            JOIN assignments ON tasks.assignment_id = assignments.id
            SET submissions.approver_id = CASE
                WHEN submissions.is_approve IS NOT NULL THEN assignments.creator_id
                ELSE NULL
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['approver_id']);
            $table->dropColumn('approver_id');
        });
    }
};
