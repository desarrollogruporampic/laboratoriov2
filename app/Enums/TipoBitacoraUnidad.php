<?php

namespace App\Enums;

use ArchTech\Enums\Options;

enum TipoBitacoraUnidad: string
{

    use Options;

    case entrada = 'Entrada';
    case salida = 'Salida';
}
