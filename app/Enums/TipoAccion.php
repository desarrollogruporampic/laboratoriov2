<?php

namespace App\Enums;

use ArchTech\Enums\Options;

enum TipoAccion: string
{

    use Options;

    case entrada = 'Entrada';
    case salida = 'Salida';
    case update = 'Salida';
    case delete = 'Salida';
}
