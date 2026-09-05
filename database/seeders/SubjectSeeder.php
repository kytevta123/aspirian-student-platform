<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'English',
                'code' => 'ENG',
                'description' => 'English language and literature.',
            ],
            [
                'name' => 'Urdu',
                'code' => 'URD',
                'description' => 'Urdu language and literature.',
            ],
            [
                'name' => 'Mathematics',
                'code' => 'MATH',
                'description' => 'Mathematics and numerical reasoning.',
            ],
            [
                'name' => 'General Science',
                'code' => 'SCI',
                'description' => 'General science concepts.',
            ],
            [
                'name' => 'Computer Science',
                'code' => 'CS',
                'description' => 'Computer science and information technology.',
            ],
            [
                'name' => 'Physics',
                'code' => 'PHY',
                'description' => 'Physics and physical sciences.',
            ],
            [
                'name' => 'Chemistry',
                'code' => 'CHEM',
                'description' => 'Chemistry and chemical sciences.',
            ],
            [
                'name' => 'Biology',
                'code' => 'BIO',
                'description' => 'Biology and life sciences.',
            ],
            [
                'name' => 'Pakistan Studies',
                'code' => 'PAK',
                'description' => 'Pakistan Studies.',
            ],
            [
                'name' => 'Islamiyat',
                'code' => 'ISL',
                'description' => 'Islamiyat.',
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::updateOrCreate(
                [
                    'code' => $subject['code'],
                ],
                [
                    'name' => $subject['name'],
                    'description' => $subject['description'],
                    'status' => 'active',
                ]
            );
        }
    }
}