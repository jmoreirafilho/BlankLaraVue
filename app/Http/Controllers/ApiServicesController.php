<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Models\Usuario;

class ApiServicesController extends Controller
{

    public function buscarCep(Request $request)
    {
        try {
            $cep = str_replace('-', '', $request->cep);

            $client = new Client(['base_uri' => 'http://cep.republicavirtual.com.br']);
            $res = $client->request('GET', '/web_cep.php', [
                'query' => [
                    'formato' => 'json',
                    'cep' => $cep
                ]
            ]);

            return $res->getBody();
            
        } catch (\Exception $e) {
            return response()->json([
                'code'      =>  500,
                'message'   =>  'Erro ao buscar CEP.'
            ], 500);
        }
        
    }

    public function downloadArquivo($nomeArquivo) {
        $headers = array(
            "Content-type"        => "application/pdf",
            "Content-Disposition" => "attachment; filename=$nomeArquivo",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        return response()->download(storage_path('app/pdf/'.$nomeArquivo), $nomeArquivo, $headers)->deleteFileAfterSend(true);

    }
}
