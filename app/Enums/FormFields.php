<?php

namespace App\Enums;

enum FormFields: string
{
    case Text = 'text';
    case Phone = 'phone';
    case Radio = 'radio';
    case Select = 'select';
    case Checkbox = 'checkbox';
    case Number = 'number';
    case TextArea = 'textarea';
    case Email = 'email';
    case Date = 'date';

    public function label(): string
    {
        return match ($this) {
            self::Text => 'Text',
            self::Phone => 'Phone',
            self::Radio => 'Radio Button',
            self::Select => 'Select Dropdown',
            self::Checkbox => 'Checkbox',
            self::Number => 'Number',
            self::TextArea => 'Text Area',
            self::Email => 'Email',
            self::Date => 'Date Picker',
        };
    }

    public function inputType(): string
    {
        return match ($this) {
            self::Text => 'text',
            self::Phone => 'tel', //frontend input type
            self::Radio, self::Select, self::Checkbox => 'selectable',
            self::Number => 'number',
            self::TextArea => 'textarea',
            self::Email => 'email',
            self::Date => 'date',
        };
    }
}
