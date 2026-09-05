<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            [
                'name' => 'Nursery',
                'code' => 'NUR',
                'level' => 0,
                'sort_order' => 0,
            ],
            [
                'name' => 'Class 1',
                'code' => 'G1',
                'level' => 1,
                'sort_order' => 2,
            ],
            [
                'name' => 'Class 2',
                'code' => 'G2',
                'level' => 2,
                'sort_order' => 3,
            ],
            [
                'name' => 'Class 3',
                'code' => 'G3',
                'level' => 3,
                'sort_order' => 4,
            ],
            [
                'name' => 'Class 4',
                'code' => 'G4',
                'level' => 4,
                'sort_order' => 5,
            ],
            [
                'name' => 'Class 5',
                'code' => 'G5',
                'level' => 5,
                'sort_order' => 6,
            ],
            [
                'name' => 'Class 6',
                'code' => 'G6',
                'level' => 6,
                'sort_order' => 7,
            ],
            [
                'name' => 'Class 7',
                'code' => 'G7',
                'level' => 7,
                'sort_order' => 8,
            ],
            [
                'name' => 'Class 8',
                'code' => 'G8',
                'level' => 8,
                'sort_order' => 9,
            ],
            [
                'name' => 'Class 9',
                'code' => 'G9',
                'level' => 9,
                'sort_order' => 10,
            ],
            [
                'name' => 'Class 10',
                'code' => 'G10',
                'level' => 10,
                'sort_order' => 11,
            ],
            [
                'name' => 'Class 11',
                'code' => 'G11',
                'level' => 11,
                'sort_order' => 12,
            ],
            [
                'name' => 'Class 12',
                'code' => 'G12',
                'level' => 12,
                'sort_order' => 13,
            ],
            [
                'name' => 'Prep',
                'code' => 'PREP',
                'level' => 13,
                'sort_order' => 1,
            ],
        ];

        foreach ($grades as $grade) {
            Grade::updateOrCreate(
                [
                    'code' => $grade['code'],
                ],
                [
                    'name' => $grade['name'],
                    'level' => $grade['level'],
                    'sort_order' => $grade['sort_order'],
                    'status' => 'active',
                ]
            );
        }
    }
}