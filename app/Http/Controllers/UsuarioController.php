<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\GrupoAcesso;
use App\Http\Resources\UsuarioResource;

class UsuarioController extends Controller
{
    
    public function login(Request $request)
    {
        if (\Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return 'true';
        }

        return response()->json([
            'code'      =>  500,
            'message'   =>  'Falha na Autenticação.'
        ], 500);
    }
    
    public function logout(Request $request)
    {
        \Auth::logout();
        
        return response()->json([
            'code'      =>  200
        ], 200);
    }

    public function verificarAcesso(Request $request)
    {
        return 'true';
    }

    public function usuarioLogado() {
        return [
            'usuario' => \Auth::user(),
            'menus' => $this->menu()
        ];
    }

    public function menu()
    {
        // if (!\Auth::user()->perfil_id) {
        //     return [];
        // }
        // $acesso = GrupoAcesso::find(\Auth::user()->perfil_id);
        $menus = [];

        $menuItems = [];
        array_push($menuItems, ['link' => '/viagens', 'titulo' => 'Viagens', 'icone' => 'transfer_within_a_station']);
        array_push($menuItems, ['link' => '/abastecimentos', 'titulo' => 'Abastecimentos', 'icone' => 'pin_drop']);
        array_push($menuItems, ['link' => '/passageiros', 'titulo' => 'Passageiros', 'icone' => 'hail']);
        array_push($menuItems, ['link' => '/rel_viagens', 'titulo' => 'Relatório de Viagens', 'icone' => 'date_range']);

        if (count($menuItems) > 0) {
            array_push($menus, [
                'icone' => 'transfer_within_a_station',
                'titulo' => 'Viagens',
                'items' => $menuItems
            ]);
        }
        
        $menuItems = [];
        array_push($menuItems, ['link' => '/vericulos', 'titulo' => 'Veículos', 'icone' => 'directions_bus']);
        array_push($menuItems, ['link' => '/manutencoes', 'titulo' => 'Manutenções', 'icone' => 'construction']);
        array_push($menuItems, ['link' => '/rel_veiculos', 'titulo' => 'Relatório de Veículo', 'icone' => 'date_range']);
        array_push($menuItems, ['link' => '/rel_motoristas', 'titulo' => 'Relatório de Motorista', 'icone' => 'date_range']);

        if (count($menuItems) > 0) {
            array_push($menus, [
                'icone' => 'directions_bus',
                'titulo' => 'Veículos',
                'items' => $menuItems
            ]);
        }

        $menuItems = [];
        array_push($menuItems, ['link' => '/contas_receber', 'titulo' => 'Contas a Receber', 'icone' => 'attach_money']);
        array_push($menuItems, ['link' => '/contas_pagar', 'titulo' => 'Contas a Pagar', 'icone' => 'payments']);
        array_push($menuItems, ['link' => '/fluxo_caixa', 'titulo' => 'Fluxo de Caixa', 'icone' => 'point_of_sale']);

        if (count($menuItems) > 0) {
            array_push($menus, [
                'icone' => 'attach_money',
                'titulo' => 'Financeiro',
                'items' => $menuItems
            ]);
        }
        
        $menuItems = [];
        array_push($menuItems, ['link' => '/perfis', 'titulo' => 'Perfis', 'icone' => 'security']);
        array_push($menuItems, ['link' => '/usuarios', 'titulo' => 'Usuários', 'icone' => 'assignment_ind']);
        array_push($menuItems, ['link' => '/clientes', 'titulo' => 'Clientes', 'icone' => 'groups']);
        array_push($menuItems, ['link' => '/checklists', 'titulo' => 'CheckLists', 'icone' => 'playlist_add_check']);
        array_push($menuItems, ['link' => '/postos', 'titulo' => 'Postos', 'icone' => 'local_gas_station']);

        if (count($menuItems) > 0) {
            array_push($menus, [
                'icone' => 'add',
                'titulo' => 'Cadastros',
                'items' => $menuItems
            ]);
        }

        return $menus;
    }

    public function buscar(Request $request)
    {
        if ($request->id) {
            return UsuarioResource::make(Usuario::find($request->id));
        }

        $busca = Usuario::select('*');

        if (isset($request->meta['per_page'])) {
            return UsuarioResource::collection($busca->paginate($request->meta['per_page']));
        }

        return UsuarioResource::collection($busca->get());
    }

    public function salvar(Request $request)
    {
        \DB::beginTransaction();
        try {
            if ($request->password != $request->password_confirmation) {
                return response()->json([
                    'code'      =>  500,
                    'message'   =>  'Senhas Diferentes.'
                ], 500);
            }

            $model = new Usuario();
            $model->fill($request->all());
            $model->password = bcrypt($request->password);
            $model->save();

            \DB::commit();
            return $model;
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'code'      =>  500,
                'message'   =>  'Erro ao salvar registro.'
            ], 500);
        }
    }

    public function atualizar(Request $request)
    {
        \DB::beginTransaction();
        try {
            
            if (($request->password || $request->password_confirmation) && ($request->password != $request->password_confirmation)) {
                return response()->json([
                    'code'      =>  500,
                    'message'   =>  'Senhas Diferentes.'
                ], 500);
            }

            $model = Usuario::find($request->id);
            $model->fill($request->all());
            if ($request->password) {
                $model->password = bcrypt($request->password);
            }
            $model->update();

            \DB::commit();
            return $model;
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'code'      =>  500,
                'message'   =>  'Erro ao atualizar registro.'
            ], 500);
        }
    }
    
    public function remover ($id) {
        \DB::beginTransaction();
        try {
            
            Usuario::destroy($id);

            \DB::commit();
            return 'true';
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'code'      =>  500,
                'message'   =>  'Erro ao remover registro.'
            ], 500);
        }
    }
}
