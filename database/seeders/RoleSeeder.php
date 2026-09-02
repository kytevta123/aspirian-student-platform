<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'STUDENT',
                'display_name' => 'Student',
                'description' => 'Student platform user.',
            ],
            [
                'name' => 'TEACHER',
                'display_name' => 'Teacher',
                'description' => 'Teacher platform user.',
            ],
            [
                'name' => 'PARENT',
                'display_name' => 'Parent',
                'description' => 'Parent or guardian platform user.',
            ],
            [
                'name' => 'SCHOOL_ADMIN',
                'display_name' => 'School Admin',
                'description' => 'Administrator for a school.',
            ],
            [
                'name' => 'PLATFORM_ADMIN',
                'display_name' => 'Platform Admin',
                'description' => 'Administrator of the Aspirian Student Platform.',
            ],
            [
                'name' => 'CONTENT_EDITOR',
                'display_name' => 'Content Editor',
                'description' => 'User responsible for educational content editing.',
            ],
            [
                'name' => 'REVIEWER',
                'display_name' => 'Reviewer',
                'description' => 'User responsible for reviewing educational content.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                [
                    'display_name' => $role['display_name'],
                    'description' => $role['description'],
                ]
            );
        }
    }
}