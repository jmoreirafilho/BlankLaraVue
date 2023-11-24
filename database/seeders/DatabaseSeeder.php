<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $perfil = new \App\Models\Perfil();
        $perfil->nome = 'ADMIN';
        $perfil->save();

        $usuario = new \App\Models\Usuario();
        $usuario->nome = 'Jose Airton';
        $usuario->email = 'airtonmrfilho@gmail.com';
        $usuario->password = bcrypt('senha123');
        $usuario->perfil_id = $perfil->id;
        $usuario->save();
    }
}
