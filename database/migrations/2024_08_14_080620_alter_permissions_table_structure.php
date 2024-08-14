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
        Schema::rename('permissions', 'old_permissions');

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('permissions')->insert([
            ['name' => 'manage-user'],
            ['name' => 'manage-department'],
            ['name' => 'manage-position'],
        ]);

        Schema::create('permission_user', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->timestamps();
        });

        $oldPermissions = DB::table('old_permissions')->get();

        foreach ($oldPermissions as $oldPermission) {
            if ($oldPermission->manage_user) {
                $permissionId = DB::table('permissions')->where('name', 'manage-user')->value('id');
                DB::table('permission_user')->insert([
                    'user_id' => $oldPermission->user_id,
                    'permission_id' => $permissionId,
                ]);
            }
            if ($oldPermission->manage_department) {
                $permissionId = DB::table('permissions')->where('name', 'manage-department')->value('id');
                DB::table('permission_user')->insert([
                    'user_id' => $oldPermission->user_id,
                    'permission_id' => $permissionId,
                ]);
            }
            if ($oldPermission->manage_position) {
                $permissionId = DB::table('permissions')->where('name', 'manage-position')->value('id');
                DB::table('permission_user')->insert([
                    'user_id' => $oldPermission->user_id,
                    'permission_id' => $permissionId,
                ]);
            }
        }

        Schema::drop('old_permissions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permissions');
        Schema::rename('old_permissions', 'permissions');
    }
};
