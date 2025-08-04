<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    /** @use HasFactory<\Database\Factories\EventRegistrationFactory> */
    use HasFactory;

    protected $fillable = [
        'event_id',
        'email',
        'responses',
        'registered_at',
        'confirmation_sent',
        'reminder_sent'
    ];

    protected $casts = [
        'responses' => 'array',
        'registered_at' => 'datetime',
        'confirmation_sent' => 'boolean',
        'reminder_sent' => 'boolean'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getFormValue($fieldName, $default = null)
    {
        return $this->responses[$fieldName] ?? $default;
    }
}
