<?php

namespace App\Console\Commands;

use App\Models\PlayerTreasure;
use Illuminate\Console\Command;
use App\Models\PlayerSubscription;

class PlayerTreasureAndSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playerTreasureAndSubscirption:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Player expired Treasure and Subscription Period are disabled successfully';

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
     * @return mixed
     */
    public function handle()
    {
        PlayerSubscription::where('end_time','<', now())->update(['status' => 0]);
        PlayerTreasure::whereMonth('close_time','!=', '0')->where('status','!=', -1)->whereDate('close_time','<', today())->update(['status' => -2]);
    }
}
