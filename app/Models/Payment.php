<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Plan;
use Carbon\Carbon;

class Payment extends Model
{
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtForHumans()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function Plan(){
        return $this->belongsTo(Plan::class);
    }
}
