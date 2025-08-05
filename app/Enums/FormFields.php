<?php

namespace App\Enums;

enum FormFields: string
{
    case Text = 'text';
    case Email = 'email';
    case Date = 'date';
    case Number = 'number';
    case Phone = 'phone';
    case TextArea = 'textarea';
    case Radio = 'radio';
    case Select = 'select';
    case Checkbox = 'checkbox';

    public function label(): string
    {
        return match($this) {
            self::Text => 'Text Input ',
            self::Email => 'Email Input',
            self::Date => 'Date Picker',
            self::Number => 'Number Input',
            self::Phone => 'Phone Number',
            self::TextArea => 'Text Area',
            self::Radio => 'Radio Button',
            self::Select => 'Select Dropdown',
            self::Checkbox => 'Checkbox',
        };
    }
    
}
