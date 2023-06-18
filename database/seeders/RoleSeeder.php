<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'administrador']);
        $role2 = Role::create(['name' => 'cajero']);

        Permission::create(['name' => 'api.productos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'api.productos.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'api.productos.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'api.productos.destroy'])->syncRoles([$role1]);

        Permission::create(['name' => 'api.register'])->syncRoles([$role1]);
        Permission::create(['name' => 'api.allusers'])->syncRoles([$role1]);
        Permission::create(['name' => 'api.deleteuser'])->syncRoles([$role1]);
        Permission::create(['name' => 'api.getuser'])->syncRoles([$role1]);
        Permission::create(['name' => 'api.updateuser'])->syncRoles([$role1]);
    }
}
