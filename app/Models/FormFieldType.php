<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormFieldType extends Model
{
    /** @use HasFactory<\Database\Factories\FormFieldTypeFactory> */
    use HasFactory;

    protected $fillable = ['label', 'type', 'required', 'options'];
    
    protected $casts = [
        'options' => 'array'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
