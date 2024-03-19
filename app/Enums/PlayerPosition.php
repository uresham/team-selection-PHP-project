<?php
namespace App\Enums;


enum PlayerPosition:string
{
    case DEFENDER = 'defender';
    case MIDFIELDER = 'midfielder';
    case FORWARD = 'forward';

    public static function getValues(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
