<?php

namespace App\Console\Commands;

use App\Http\Repositories\RenderClouds\RenderCloudRepo;
use App\Models\RenderClouds;
//use App\Models\WhatsAppBotsModel;
//use App\Repositories\BotWhatsApp\BotWhatsApp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class fiveMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Clouds:ping';

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
        $WhatsAppBotsModel = RenderClouds::get();

        foreach ( $WhatsAppBotsModel as $e ){

            $this->info($e);
            $resp = RenderCloudRepo::ping($e->url);
            $this->info($e->url .' = '.$resp);

        }
        Log::debug('SUCCESS - Clouds:ping');

        return 0;
    }
}
