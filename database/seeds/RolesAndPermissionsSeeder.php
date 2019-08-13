<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $users = [
            'register user', 'edit user', 'delete user', 'assign role', 'remove role',
        ];

        $materials = [
            'create material', 'edit material', 'delete material',
        ];

        $products = [
            'create product', 'edit product', 'delete product',
        ];

        $works = [
            'create work', 'edit work', 'delete work',
        ];

        $purchases = [
            'create purchase', 'edit purchase', 'delete purchase',
        ];

        foreach (array_merge(
            $users,
            $materials,
            $products,
            $works,
            $purchases) as $permission) {
            Permission::create([ 'name' => $permission, 'guard_name' => 'api' ]);
        }

        // create roles and assign created permissions
        Role::create([ 'name' => 'admin', 'guard_name' => 'api' ])
            ->givePermissionTo($users);

        Role::create([ 'name' => 'gudang', 'guard_name' => 'api' ])
            ->givePermissionTo($materials);

        Role::create([ 'name' => 'produksi', 'guard_name' => 'api' ])
            ->givePermissionTo($products);

        Role::create([ 'name' => 'ppic', 'guard_name' => 'api' ])
            ->givePermissionTo($works);

        Role::create([ 'name' => 'marketing', 'guard_name' => 'api' ])
            ->givePermissionTo($purchases);
    }
}
