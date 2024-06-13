<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'accepted',
        'blocked',
        'invitation',
        'invite_accept',
    ];

    public function getApplicationDisplayFields()
    {
        return [
            'user' => $this->user(),
            'group' => $this->group(),
            'accepted' => $this->accepted,
            'blocked' => $this->blocked,
            'invitation' => $this->invitation,
            'invite_accept' => $this->invite_accept,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'id');
    }
}
