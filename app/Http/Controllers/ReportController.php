<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function invoiceReport(Request $request)
    {
        $user = $request->user();
        $subscriptions = Subscription::where('user_id', $user->id)
            ->withCount('invoices')
            ->get();
        foreach ($subscriptions as $subscription){
            $subscription->setAttribute('cost', $subscription->invoices_count*$subscription->price);
        }
        return response($subscriptions);
    }
}
