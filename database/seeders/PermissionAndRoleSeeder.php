<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'superadmin',
            'admin',
            'checker'
        ];

        foreach($roles as $role){
            Role::firstOrCreate(['name'=>$role]);
        }

        $permissions = [
            'full_access',
            'manage_contributors',
            'verify_invitation'
        ];

        foreach($permissions as $permission){
            Permission::firstOrCreate(['name'=>$permission]);
        }

        /** grant super admin all the roles
         * then the super admin will create roles
         * and assign them permissions to specific users
        */

        $super_admin = Role::where('name', 'superadmin')->first();

        $super = Permission::all();

        $super_admin->syncPermissions($super);

        $user = User::where('email', 'fanuelnashon1@gmail.com')->first();

        $user->assignRole($super_admin);

    }
}
