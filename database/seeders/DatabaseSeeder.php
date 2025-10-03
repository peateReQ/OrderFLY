<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RolesSeeder::class);

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@crm.test',
                'password' => bcrypt('admin123'),
                'roles' => ['Administrator'],
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@crm.test',
                'password' => bcrypt('manager123'),
                'roles' => ['Manager Sprzedaży'],
            ],
            [
                'name' => 'Handlowiec',
                'email' => 'sales@crm.test',
                'password' => bcrypt('sales123'),
                'roles' => ['Handlowiec'],
            ],
            [
                'name' => 'Obsługa Klienta',
                'email' => 'support@crm.test',
                'password' => bcrypt('support123'),
                'roles' => ['Obsługa Klienta'],
            ],
            [
                'name' => 'Magazynier',
                'email' => 'warehouse@crm.test',
                'password' => bcrypt('warehouse123'),
                'roles' => ['Magazynier'],
            ],
            [
                'name' => 'Pracownik Produkcji',
                'email' => 'production@crm.test',
                'password' => bcrypt('production123'),
                'roles' => ['Pracownik Produkcji'],
            ],
            [
                'name' => 'Księgowość',
                'email' => 'accounting@crm.test',
                'password' => bcrypt('accounting123'),
                'roles' => ['Księgowość'],
            ],
        ];

        foreach ($users as $data) {
            $user = \App\Models\User::firstOrCreate([
                'email' => $data['email']
            ], [
                'name' => $data['name'],
                'password' => $data['password'],
            ]);
            foreach ($data['roles'] as $role) {
                $user->assignRole($role);
            }
        }
    }
}
