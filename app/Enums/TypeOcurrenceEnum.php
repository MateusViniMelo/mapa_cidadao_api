<?php

namespace App\Enums;

enum TypeOcurrenceEnum: string
{
    case ILUMINACAO       = 'Iluminação';
    case BURACO           = 'Buraco';
    case ALAGAMENTO       = 'Alagamento';
    case LIXO             = 'Lixo';
    case SEM_PAVIMENTACAO = 'Sem Pavimentacao';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
