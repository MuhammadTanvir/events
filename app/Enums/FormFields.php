<?php

namespace App\Enums;

enum FormFields: string
{
    case Text = 'text';
    case Email = 'email';
    case Date = 'date';
    case Number = 'number';
    case TextArea = 'textarea';
    case Radio = 'radio';
    case Select = 'select';
    case Checkbox = 'checkbox';
    
}
