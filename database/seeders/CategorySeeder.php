<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            ['name' => 'Dog Food',           'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cat Food',           'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dog Treats',         'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cat Treats',         'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Grooming & Hygiene', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Health & Vitamins',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Accessories',        'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Toys',               'created_at' => $now, 'updated_at' => $now],
        ];

        // Requires a unique index on `name` (usual case)
        Category::upsert($rows, ['name'], ['updated_at']);
    }
}
