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
        $user->tipo_usuario = 'adminstrador';
        $user->ruta_imagen_usuario = 'nohay';
        $user->email = 'admin@easybill.com';
        $user->password = bcrypt(123456);

        $user->save();

        User::factory(50)->create();
    }
}
