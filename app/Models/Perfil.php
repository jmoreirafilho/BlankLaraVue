<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';

    protected $fillable = [
        'nome',
        'flag_viagens',
        'flag_abastecimentos',
        'flag_passageiros',
        'flag_rel_viagens',
        'flag_veiculos',
        'flag_manutencoes',
        'flag_rel_veiculos',
        'flag_rel_motoristas',
        'flag_contas_receber',
        'flag_contas_pagar',
        'flag_fluxo_caixa',
        'flag_perfis',
        'flag_usuarios',
        'flag_clientes',
        'flag_postos',
        'flag_checklists'
    ];

}
