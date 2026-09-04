<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'view_dashboard',
                'display_name' => 'View Dashboard',
                'description' => 'Access the application dashboard.',
            ],
            [
                'name' => 'manage_users',
                'display_name' => 'Manage Users',
                'description' => 'Create, update, and manage users.',
            ],
            [
                'name' => 'manage_roles',
                'display_name' => 'Manage Roles',
                'description' => 'Create, update, and manage roles.',
            ],
            [
                'name' => 'manage_permissions',
                'display_name' => 'Manage Permissions',
                'description' => 'Create, update, and manage permissions.',
            ],
            [
                'name' => 'manage_content',
                'display_name' => 'Manage Content',
                'description' => 'Create, update, and manage educational content.',
            ],
            [
                'name' => 'review_content',
                'display_name' => 'Review Content',
                'description' => 'Review educational content.',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description'],
                ]
            );
        }
    }
}