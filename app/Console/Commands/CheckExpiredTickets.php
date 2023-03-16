<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired tickets and update their status';

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
     * /c/laragon/www/laradesk/artisan
     * @return int
     */
    public function handle()
    {
        $expiredTickets=Ticket::where('status_id',1)
                              ->where('expiry_date', '<=',Carbon::now())
                              ->get();
        
        foreach($expiredTickets as $ticket){
            $ticket->status_id=5;
            $ticket->save();
        }

        $this->info('Expired tickets checked');
    }
}
