<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Availability extends Model
{
    protected $fillable = [
        'user_id',
        'day_of_week',
        'date',
        'start_time',
        'end_time',
        'is_recurring',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
