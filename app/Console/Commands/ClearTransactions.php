<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Console\Command;

class ClearTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear-transactions';

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
        Payment::query()->delete();
        TransactionItem::query()->delete();
        Transaction::query()->delete();
    }
}
