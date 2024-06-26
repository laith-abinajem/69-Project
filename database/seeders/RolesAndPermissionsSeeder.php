<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $subscriberRole = Role::create(['name' => 'Subscriber']);
        $employeeRole = Role::create(['name' => 'Employee']);

        // Retrieve users by their type
        $superAdmin = User::where('type', 'super_admin')->first();
        $subscriber = User::where('type', 'subscriber')->first();
        $employee = User::where('type', 'employee')->first();

        // Assign roles to users
        if ($superAdmin) {
            $superAdmin->assignRole($superAdminRole);
        }

        if ($subscriber) {
            $subscriber->assignRole($subscriberRole);
        }

        if ($employeeRole) {
            $employee->assignRole($employeeRole);
        }

        // Create permissions
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'view user']);
        // Assign permissions to roles
        $superAdminRole->givePermissionTo(Permission::all());
        Permission::create(['name' => 'owne tint brand']);
        Permission::create(['name' => 'employee']);
        $subscriberRole->givePermissionTo('owne tint brand');
        $employeeRole->givePermissionTo('employee');
    }
}
