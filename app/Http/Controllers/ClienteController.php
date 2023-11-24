<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cliente;

use App\Http\Resources\ClienteResource;

class ClienteController extends Controller
{

    public function buscar(Request $request)
    {
        if ($request->id) {
            return ClienteResource::make(Cliente::find($request->id));
        }

        $busca = Cliente::select('*');

        return $busca->get();

        if (isset($request->meta['per_page'])) {
            return ClienteResource::collection($busca->paginate($request->meta['per_page']));
        }

        return ClienteResource::collection($busca->get());
    }

    public function salvar(Request $request)
    {
        \DB::beginTransaction();
        try {

            $model = new Cliente();
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
            
            $model = Cliente::find($request->id);
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
            
            Cliente::destroy($id);

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
