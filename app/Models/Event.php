<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'slug',
        'is_active',
        'max_participants',
        'created_by'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function fields()
    {
        return $this->hasMany(FormFieldType::class);
    }
    
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title) . '-' . Str::random(6);
            }
        });
    }

    public function getRegistrationCountAttribute()
    {
        return $this->registrations()->count();
    }

    public function canAcceptRegistrations()
    {
        if (!$this->is_active) return false;
        if ($this->max_participants && $this->registration_count >= $this->max_participants) return false;
        return true;
    }

    public function getPublicUrlAttribute()
    {
        return route('events.register', $this->slug);
    }

    public function isFull()
    {
        return $this->max_participants && $this->registrations()->count() >= $this->max_participants;
    }
}
