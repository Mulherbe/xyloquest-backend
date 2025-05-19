<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'default_points_per_hour',
    ];
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
