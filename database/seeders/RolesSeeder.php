<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Administrator',
            'Manager Sprzedaży',
            'Handlowiec',
            'Obsługa Klienta',
            'Magazynier',
            'Pracownik Produkcji',
            'Księgowość',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
