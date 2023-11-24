<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\Perfil;
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
        if (!\Auth::user()->perfil_id) {
            return [];
        }
        $acesso = Perfil::find(\Auth::user()->perfil_id);
        $menus = [];
        
        $menuItems = [];
        array_push($menuItems, ['link' => '/perfis', 'titulo' => 'Perfis', 'icone' => 'security']);
        array_push($menuItems, ['link' => '/usuarios', 'titulo' => 'Usuários', 'icone' => 'assignment_ind']);
        array_push($menuItems, ['link' => '/clientes', 'titulo' => 'Clientes', 'icone' => 'groups']);

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
