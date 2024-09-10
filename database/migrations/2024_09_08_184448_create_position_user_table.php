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
        Schema::create('position_user', function (Blueprint $table) {
            $table->foreignUuid('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Automatically populate the table with existing data
        $this->populatePositionUser();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_user');
    }

    /**
     * Populate position_user table with existing data.
     */
    private function populatePositionUser()
    {
        // Fetch users with non-null positions
        $users = DB::table('users')->whereNotNull('position_id')->get();

        // Insert data into position_user table
        foreach ($users as $user) {
            DB::table('position_user')->insert([
                'user_id' => $user->id,
                'position_id' => $user->position_id,
            ]);
        }
    }
};
