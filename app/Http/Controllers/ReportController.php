<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function invoiceReport(Request $request)
    {
        $user = $request->user();
        $subscriptions = Subscription::where('user_id', $user->id)->withTrashed()->get();
        foreach ($subscriptions as $subscription){
            $create = Carbon::createFromTimeString($subscription->created_at);
            if ($subscription->deleted_at == null){
                $cost = Carbon::now()->sub($create)->diffInMinutes()/10;
            }
            else{
                $delete = Carbon::createFromTimeString($subscription->deleted_at);
                $cost = $delete->sub($create)->diffInMinutes()/10;
            }
            $subscription->setAttribute('cost', floor($cost));
        }
        return response($subscriptions);
    }
}
