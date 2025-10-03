<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Przykładowe role
        $roles = [
            ['name' => 'Administrator', 'priority' => 100, 'description' => 'Pełny dostęp'],
            ['name' => 'Manager Sprzedaży', 'priority' => 80, 'description' => 'Zarządza sprzedażą'],
            ['name' => 'Handlowiec', 'priority' => 60, 'description' => 'Obsługuje klientów i sprzedaż'],
            ['name' => 'Obsługa Klienta', 'priority' => 50, 'description' => 'Wsparcie klienta'],
            ['name' => 'Magazynier', 'priority' => 40, 'description' => 'Obsługa magazynu'],
            ['name' => 'Pracownik Produkcji', 'priority' => 30, 'description' => 'Produkcja'],
            ['name' => 'Księgowość', 'priority' => 20, 'description' => 'Finanse i płatności'],
        ];

        foreach ($roles as $roleData) {
            \App\Models\Role::firstOrCreate(['name' => $roleData['name']], $roleData);
        }

        // Przykładowe uprawnienia
        $permissions = [
            ['name' => 'user_crud', 'description' => 'CRUD użytkowników'],
            ['name' => 'contractor_crud', 'description' => 'CRUD kontrahentów'],
            ['name' => 'product_crud', 'description' => 'CRUD produktów'],
            ['name' => 'opportunity_crud', 'description' => 'CRUD szans sprzedaży'],
            ['name' => 'offer_crud', 'description' => 'CRUD ofert'],
            ['name' => 'order_crud', 'description' => 'CRUD zamówień'],
            ['name' => 'payment_crud', 'description' => 'CRUD płatności'],
            ['name' => 'production_crud', 'description' => 'CRUD produkcji'],
            ['name' => 'report_read', 'description' => 'Odczyt raportów'],
            // granularne
            ['name' => 'can_edit_price', 'description' => 'Może edytować cenę'],
            ['name' => 'can_adjust_stock', 'description' => 'Może korygować stany magazynowe'],
            ['name' => 'can_create_promotion', 'description' => 'Może tworzyć promocje'],
            ['name' => 'can_export_data', 'description' => 'Może eksportować dane'],
            ['name' => 'can_view_audit_log', 'description' => 'Może przeglądać logi audytu'],
        ];

        foreach ($permissions as $permData) {
            \App\Models\Permission::firstOrCreate(['name' => $permData['name']], $permData);
        }

        // Powiązania ról z uprawnieniami i scope według siatki
        $roleMatrix = [
            'Administrator' => [
                'user_crud' => 'global',
                'contractor_crud' => 'global',
                'product_crud' => 'global',
                'opportunity_crud' => 'global',
                'offer_crud' => 'global',
                'order_crud' => 'global',
                'payment_crud' => 'global',
                'production_crud' => 'global',
                'report_read' => 'global',
                'can_edit_price' => 'global',
                'can_adjust_stock' => 'global',
                'can_create_promotion' => 'global',
                'can_export_data' => 'global',
                'can_view_audit_log' => 'global',
            ],
            'Manager Sprzedaży' => [
                'user_crud' => 'read',
                'contractor_crud' => 'global',
                'product_crud' => 'read',
                'opportunity_crud' => 'read',
                'offer_crud' => 'read',
                'order_crud' => 'read',
                'payment_crud' => 'read',
                'production_crud' => 'read',
                'report_read' => 'global',
            ],
            'Handlowiec' => [
                'contractor_crud' => 'own',
                'product_crud' => 'read',
                'opportunity_crud' => 'own',
                'offer_crud' => 'own',
                'order_crud' => 'own',
                'payment_crud' => 'read',
                'report_read' => 'own',
            ],
            'Obsługa Klienta' => [
                'contractor_crud' => 'global',
                'product_crud' => 'read',
                'order_crud' => 'global',
                'report_read' => 'global',
            ],
            'Magazynier' => [
                'product_crud' => 'read',
                'order_crud' => 'global',
                'production_crud' => 'global',
                'report_read' => 'global',
            ],
            'Pracownik Produkcji' => [
                'production_crud' => 'global',
            ],
            'Księgowość' => [
                'payment_crud' => 'global',
                'contractor_crud' => 'read',
                'report_read' => 'global',
            ],
        ];

        foreach ($roleMatrix as $roleName => $perms) {
            $role = \App\Models\Role::where('name', $roleName)->first();
            foreach ($perms as $permName => $scope) {
                $perm = \App\Models\Permission::where('name', $permName)->first();
                if ($role && $perm) {
                    $role->permissions()->attach($perm->id, ['scope' => $scope]);
                }
            }
        }
        // Granularne uprawnienia możesz dodać analogicznie, rozbudowując powyższą matrycę
    }
}
