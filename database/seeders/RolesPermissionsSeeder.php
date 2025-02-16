<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run() {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * create permissions for all roles
         */
        $permissions = [
            // Product Management
            'create-products',
            'edit-products',
            'delete-products',
            'view-products',
            'manage-categories',
            'manage-inventory',

            // Order Management
            'place-orders',
            'view-own-orders',
            'view-all-orders',
            'update-order-status',
            'process-refunds',
            'cancel-orders',

            // User Management
            'view-users',
            'edit-users',
            'delete-users',
            'assign-roles',
            'manage-permissions',

            // Financial & Analytics
            'view-sales-reports',
            'manage-payments',
            'view-transactions',
            'export-reports',

            // Content & Marketing
            'manage-blogs',
            'manage-coupons',
            'manage-banners',

            // Support & Tickets
            'create-tickets',
            'respond-to-tickets',
            'close-tickets',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo([
            'create-products',
            'edit-products',
            'delete-products',
            'view-products',
            'manage-categories',
            'manage-inventory',
            'view-all-orders',
            'update-order-status',
            'process-refunds',
            'view-users',
            'edit-users',
            'view-sales-reports',
            'manage-payments',
            'view-transactions',
            'export-reports',
            'manage-coupons',
            'manage-banners',
            'respond-to-tickets',
            'close-tickets',
        ]);

        $customer = Role::create(['name' => 'Customer']);
        $customer->givePermissionTo([
            'view-products',
            'place-orders',
            'view-own-orders',
            'cancel-orders',
            'create-tickets',
        ]);

        $vendor = Role::create(['name' => 'Vendor']);
        $vendor->givePermissionTo([
            'create-products',
            'edit-products',
            'delete-products',
            'view-products',
            'view-sales-reports',
        ]);

        $supportAgent = Role::create(['name' => 'Support Agent']);
        $supportAgent->givePermissionTo([
            'view-all-orders',
            'process-refunds',
            'respond-to-tickets',
            'close-tickets',
        ]);

        $inventoryManager = Role::create(['name' => 'Inventory Manager']);
        $inventoryManager->givePermissionTo([
            'manage-inventory',
            'view-all-orders',
        ]);

        $contentManager = Role::create(['name' => 'Content Manager']);
        $contentManager->givePermissionTo([
            'manage-categories',
            'manage-blogs',
            'manage-coupons',
            'manage-banners',
        ]);
        $superAdminUser = User::create([
            'username' => env('SUPER_ADMIN_USERNAME'),
            'first_name' => env('SUPER_ADMIN_FIRST_NAME'),
            'last_name' => env('SUPER_ADMIN_LAST_NAME'),
            'email' => env('SUPER_ADMIN_EMAIL'),
            'password' => Hash::make(env('SUPER_ADMIN_PASSWORD')),
            'phone' => env('SUPER_ADMIN_PHONE'),
        ]);
        $superAdminUser->assignRole('Super admin');
    }
}
