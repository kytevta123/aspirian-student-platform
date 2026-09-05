<?php

namespace Database\Seeders;

use App\Models\EducationSystem;
use Illuminate\Database\Seeder;

class EducationSystemSeeder extends Seeder
{
    public function run(): void
    {
        EducationSystem::updateOrCreate(
            [
                'name' => 'Pakistan Education System',
            ],
            [
                'country' => 'Pakistan',
                'status' => 'active',
            ]
        );
    }
}