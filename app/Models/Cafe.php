<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\CafePhoto;
use App\Models\CafeSchedule;

class Cafe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'about',
        'address',
        'maps_embed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cafe) {
            $cafe->slug = Str::slug($cafe->name);
            $original = $cafe->slug;
            $count = 1;
            while (static::where('slug', $cafe->slug)->exists()) {
                $cafe->slug = $original . '-' . $count++;
            }
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photos()
    {
        return $this->hasMany(CafePhoto::class);
    }

    public function primaryPhoto()
    {
        return $this->hasOne(CafePhoto::class)->where('is_primary', true);
    }

    public function schedules()
    {
        return $this->hasMany(CafeSchedule::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function reviewCount()
    {
        return $this->reviews()->count();
    }

    public function isOpenNow()
    {
        $today = strtolower(now()->format('l'));
        $schedule = $this->schedules()->where('day', $today)->first();

        if (!$schedule || $schedule->is_closed) {
            return false;
        }

        $now = now()->format('H:i:s');
        return $now >= $schedule->open_time && $now <= $schedule->close_time;
    }

    public function todaySchedule()
    {
        $today = strtolower(now()->format('l'));
        return $this->schedules()->where('day', $today)->first();
    }
}
