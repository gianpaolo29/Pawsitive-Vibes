<?php

namespace App\Console\Commands;

use App\Models\Donation;
use App\Models\DonationItem;
use Illuminate\Console\Command;

class ClearDonations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-donations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DonationItem::query()->delete();
        Donation::query()->delete();
    }
}
