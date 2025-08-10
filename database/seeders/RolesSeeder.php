<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RolesModel;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        RolesModel::firstOrCreate([
            'nombre' => 'common',
        ], [
            'activo' => true,
        ]);

        RolesModel::firstOrCreate([
            'nombre' => 'admin',
        ], [
            'activo' => true,
        ]);
    }
}
