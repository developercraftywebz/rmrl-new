<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GifComment extends Model
{
    use HasFactory;
    public function getTypeAttribute()
    {
        return 'gif';
    }
}
