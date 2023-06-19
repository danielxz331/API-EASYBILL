<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();

        $user->name = "Admin";
        $user->tipo_usuario = 'administrador';
        $user->ruta_imagen_usuario = 'nohay';
        $user->email = 'admin@easybill.com';
        $user->password = bcrypt(123456);
        $user->assignRole('administrador');

        $user->save();

        $user2 = new User();

        $user2->name = "CAJERO";
        $user2->tipo_usuario = 'cajero';
        $user2->ruta_imagen_usuario = 'nohay';
        $user2->email = 'cajero@easybill.com';
        $user2->password = bcrypt(123456);
        $user2->assignRole('cajero');

        $user2->save();

        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('cajero');
        });
    }
}
