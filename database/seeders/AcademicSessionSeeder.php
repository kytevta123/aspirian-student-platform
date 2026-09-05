<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use Illuminate\Database\Seeder;

class AcademicSessionSeeder extends Seeder
{
    public function run(): void
    {
        AcademicSession::updateOrCreate(
            [
                'name' => '2026-27',
            ],
            [
                'start_date' => '2026-04-01',
                'end_date' => '2027-03-31',
                'status' => 'active',
            ]
        );
    }
}