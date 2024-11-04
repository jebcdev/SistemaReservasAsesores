<?php

namespace App\Enums;

enum PaymentStatusEnum:string
{
    case PENDIENTE = 'PENDIENTE';
    case PAGADO = 'PAGADO';
    case FALLIDO = 'FALLIDO';
    

    public static function toArray(): array
  {
    return array_column(self::cases(), 'value');
  }
    
}
