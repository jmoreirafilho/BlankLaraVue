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
        $perfil->flag_perfis = 'S';
        $perfil->flag_usuarios = 'S';
        $perfil->flag_clientes = 'S';
        $perfil->save();

        $usuario = new \App\Models\Usuario();
        $usuario->nome = 'Nome do Admin';
        $usuario->email = 'admin@email.com';
        $usuario->password = bcrypt('senha123');
        $usuario->perfil_id = $perfil->id;
        $usuario->save();
    }
}
