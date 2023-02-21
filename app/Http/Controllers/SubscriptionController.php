<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\StoreRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(StoreRequest $request){
        $subData = $request->validated();
        $subData['user_id'] = $request->user()->id;
        $subscription = Subscription::create($subData);
        return response($subscription, 201);
    }

    public function unsubscribe(Subscription $subscription){
        if (auth()->user()->id === $subscription->user_id){
            $subscription->delete();
            return response(['message' => 'Subscription canceled!'], 200);
        }
        return response(['message' => 'Access denied!'], 403);
    }
}
