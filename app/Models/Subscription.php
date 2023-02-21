<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'user_id'
    ];

    public function user(){
        $this->belongsTo(User::class);
    }

    public function invoice(){
        $this->hasMany(Invoice::class);
    }
}
