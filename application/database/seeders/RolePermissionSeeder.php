<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_has_permissions')->delete();
        DB::statement("ALTER TABLE `role_has_permissions` AUTO_INCREMENT = 1");

        DB::table('permissions')->delete();
        DB::statement("ALTER TABLE `permissions` AUTO_INCREMENT = 1");

        DB::table('roles')->delete();
        DB::statement("ALTER TABLE `roles` AUTO_INCREMENT = 1");

//        DB::table('users')->delete();
        DB::statement("ALTER TABLE `users` AUTO_INCREMENT = 1");

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create user management permissions
        Permission::create(['name' => 'view user management', 'group_name' => 'user management', 'permission_type' => 1, 'guard_name' => 'admin']);
        Permission::create(['name' => 'create user management', 'group_name' => 'user management', 'permission_type' => 2, 'guard_name' => 'admin']);
        Permission::create(['name' => 'update user management', 'group_name' => 'user management', 'permission_type' => 3, 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete user management', 'group_name' => 'user management', 'permission_type' => 4, 'guard_name' => 'admin']);

        // create role management permissions
        Permission::create(['name' => 'view role management', 'group_name' => 'role management', 'permission_type' => 1, 'guard_name' => 'admin']);
        Permission::create(['name' => 'create role management', 'group_name' => 'role management', 'permission_type' => 2, 'guard_name' => 'admin']);
        Permission::create(['name' => 'update role management', 'group_name' => 'role management', 'permission_type' => 3, 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete role management', 'group_name' => 'role management', 'permission_type' => 4, 'guard_name' => 'admin']);

        // create bill management permissions
        Permission::create(['name' => 'view bill management', 'group_name' => 'bill management', 'permission_type' => 1, 'guard_name' => 'admin']);
        Permission::create(['name' => 'create bill management', 'group_name' => 'bill management', 'permission_type' => 2, 'guard_name' => 'admin']);
        Permission::create(['name' => 'update bill management', 'group_name' => 'bill management', 'permission_type' => 3, 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete bill management', 'group_name' => 'bill management', 'permission_type' => 4, 'guard_name' => 'admin']);

        // create meter management permissions
        Permission::create(['name' => 'view meter management', 'group_name' => 'meter management', 'permission_type' => 1, 'guard_name' => 'admin']);
        Permission::create(['name' => 'create meter management', 'group_name' => 'meter management', 'permission_type' => 2, 'guard_name' => 'admin']);
        Permission::create(['name' => 'update meter management', 'group_name' => 'meter management', 'permission_type' => 3, 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete meter management', 'group_name' => 'meter management', 'permission_type' => 4, 'guard_name' => 'admin']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin', 'role_type' => 1]);
        $role1->givePermissionTo(Permission::all());

        // create demo users
        $user1 = Admin::whereEmail('admin@admin.com')->first();

        $user1->assignRole($role1);

    }
}
