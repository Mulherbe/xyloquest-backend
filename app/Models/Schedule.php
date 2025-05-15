<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['activity_id', 'recurrence_rule', 'next_occurrence'];

    protected $casts = [
        'next_occurrence' => 'datetime',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
