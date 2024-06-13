<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    public function Plan()
    {
        return $this->belongsTo(Plan::class, 'stripe_price', 'price_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCreatedAtForHumans()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
