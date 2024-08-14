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
        // Recreate the old_permissions table
        Schema::create('old_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->boolean('manage_user')->default(false);
            $table->boolean('manage_department')->default(false);
            $table->boolean('manage_position')->default(false);
            $table->timestamps();
        });

        // Retrieve the permissions and user associations
        $permissionUser = DB::table('permission_user')->get();

        foreach ($permissionUser as $permission) {
            $newPermissionName = DB::table('permissions')->where('id', $permission->permission_id)->value('name');
            $permissionName = str_replace('-', '_', $newPermissionName);

            DB::table('old_permissions')->updateOrInsert(
                ['user_id' => $permission->user_id],
                [$permissionName => true]
            );
        }

        // Drop the permission_user table
        Schema::dropIfExists('permission_user');

        // Drop the permissions table
        Schema::dropIfExists('permissions');

        // Rename old_permissions back to permissions
        Schema::rename('old_permissions', 'permissions');
    }
};
