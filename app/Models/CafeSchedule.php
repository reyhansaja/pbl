<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafeSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'cafe_id',
        'day',
        'open_time',
        'close_time',
        'is_closed',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    public function getFormattedTimeAttribute()
    {
        if ($this->is_closed) {
            return 'Closed';
        }
        return date('h:i A', strtotime($this->open_time)) . ' - ' . date('h:i A', strtotime($this->close_time));
    }
}
