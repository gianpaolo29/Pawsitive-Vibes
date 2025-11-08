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
            ['name' => 'Dog Products',      'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cat Products',      'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Fish & Aquatic',    'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Food & Treats',     'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Accessories',       'created_at' => $now, 'updated_at' => $now],
        ];

        // Requires a unique index on `name` (usual case)
        Category::upsert($rows, ['name'], ['updated_at']);
    }
}
