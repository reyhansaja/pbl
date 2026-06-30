<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cafe_id',
        'rating',
        'comment',
        'images',
        'is_reported',
        'report_count',
        'reported_at',
    ];

    protected $casts = [
        'images' => 'array',
        'is_reported' => 'boolean',
        'report_count' => 'integer',
        'reported_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    public function reply()
    {
        return $this->hasOne(ReviewReply::class);
    }
}
