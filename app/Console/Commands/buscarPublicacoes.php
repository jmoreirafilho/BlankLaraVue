<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class buscarPublicacoes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buscarPublicacoes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $desc = \App\Models\Publicacao::first()->descricao;

        $novaDesc = $desc;

        $allUrls = [];
        $urls = [];

        while(preg_match('/(www\.jusbrasil\.com\.br\/diarios\/[0-9]+\/[0-9|\-|a-z]+)\'/i', $novaDesc, $urls)){
            array_push($allUrls, $urls[1]);
            $novaDesc = str_replace($urls[1], '', $novaDesc);
        }

        var_dump($allUrls);
    }
}
