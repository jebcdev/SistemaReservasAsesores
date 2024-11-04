<?php

namespace App\Enums;

enum ReservationStatusEnum:string
{
    case PENDIENTE = 'PENDIENTE';
    case CONFIRMADA = 'CONFIRMADA';
    case PAGADA = 'PAGADA';
    case CANCELADA = 'CANCELADA';
    
    public static function toArray(): array
    {
      return array_column(self::cases(), 'value');
    }
}
