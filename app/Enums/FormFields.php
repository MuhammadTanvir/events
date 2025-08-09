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
            self::Text => 'Text Input',
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

    public function inputType(): string
    {
        return match($this) {
            self::Text => 'text',
            self::Email => 'email',
            self::Date => 'date',
            self::Number => 'number',
            self::Phone => 'tel', //frontend input type
            self::TextArea => 'textarea',
            self::Radio, self::Select, self::Checkbox => 'selectable', // handled differently
        };
    }
}

