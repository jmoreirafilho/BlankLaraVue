<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Perfil;

use App\Http\Resources\PerfilResource;

class PerfilController extends Controller
{

    public function buscar(Request $request)
    {
        if ($request->id) {
            return PerfilResource::make(Perfil::find($request->id));
        }

        $busca = Perfil::select('*');

        if (isset($request->meta['per_page'])) {
            return PerfilResource::collection($busca->paginate($request->meta['per_page']));
        }

        return PerfilResource::collection($busca->get());
    }

    public function salvar(Request $request)
    {
        \DB::beginTransaction();
        try {

            $model = new Perfil();
            $model->fill($request->all());
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
            
            $model = Perfil::find($request->id);
            $model->fill($request->all());
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
            
            Perfil::destroy($id);

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
