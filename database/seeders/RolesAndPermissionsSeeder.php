<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     */
    
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
                $school = Role::create(['name' => 'School']);
                $technician = Role::create(['name' => 'Technician']);
                $staff = Role::create(['name' => 'RTB-Staff']);
                $admin = Role::create(['name' => 'Admin']);
        
        // Define permissions
        $permissions = [
            // Assets
            'asset.view',
            'asset.assign_to_school',
            'asset.create',
            'asset.update',
            'asset.delete',
            
            // Requests
            'request.create_new',
            'request.create_maintenance',
            'request.view_own',
            'request.view_all',
            'request.approve',
            'request.assign_technician',
            
            // Maintenance
            'maintenance.update_status',
            'maintenance.view_assigned',
            'maintenance.view_all',
            
            // Reports
            'report.submit',
            'report.view_own',
            'report.view_all',
            'report.generate_summary',

            // Histories
            'history.asset_movement.view',
            'history.maintenance.view',
            'history.request.view',
            'history.report.view',

            // System Admin
            'user.manage',
            'role.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

         // Assign permissions to roles
         $school->givePermissionTo([
            'request.create_new',
            'request.create_maintenance',
            'request.view_own',
            'report.submit',
            'report.view_own',
            'history.report.view',
        ]);

        $technician->givePermissionTo([
            'maintenance.update_status',
            'maintenance.view_assigned',
            'history.maintenance.view',
        ]);

        $staff->givePermissionTo([
            'asset.view',
            'asset.assign_to_school',
            'request.view_all',
            'request.approve',
            'request.assign_technician',
            'maintenance.view_all',
            'report.view_all',
            'report.generate_summary',
            'history.asset_movement.view',
            'history.maintenance.view',
            'history.request.view',
            'history.report.view',
        ]);

        $admin->givePermissionTo(Permission::all()); // Admin has all permissions
    

        
        
    }
}