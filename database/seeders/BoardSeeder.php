<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\EducationSystem;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    public function run(): void
    {
        $educationSystem = EducationSystem::where(
            'name',
            'Pakistan Education System'
        )->firstOrFail();

        Board::updateOrCreate(
            [
                'code' => 'PB',
            ],
            [
                'education_system_id' => $educationSystem->id,
                'name' => 'Punjab Board',
                'status' => 'active',
            ]
        );
    }
}