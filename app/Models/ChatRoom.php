<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;

class ChatRoom extends Model
{
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function Author(){
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function Participant(){
        return $this->belongsTo(User::class, 'participant_id', 'id');
    }
}
