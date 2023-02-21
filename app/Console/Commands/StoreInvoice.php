<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class StoreInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add invoices based on subscription';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $invoices = Invoice::select('subscription_id')->distinct()
            ->where('created_at', '<=', Carbon::now()->subMinutes(10))
            ->with(['subscription' => function(Builder $query){
                $query->where('deleted_at', null);
            }])
            ->get();
        $subscriptions = Subscription::select('id')
            ->where('created_at', '>=', Carbon::now()->subMinutes(10))
            ->where('deleted_at', null)
            ->get();
        $newInvoices = new Collection();
        foreach ($invoices as $invoice){
            if ($invoice->subscription->deleted_at == null){
                $newInvoices->add(
                    ['subscription_id' => $invoice->subscription_id]
                );
            }
        }
        foreach ($subscriptions as $subscription){
            $newInvoices->add(
                ['subscription_id' => $subscription->id]
            );
        }
        Invoice::insert($newInvoices->toArray());
        $count = $newInvoices->count();
        $this->info("$count invoices added");
    }
}
