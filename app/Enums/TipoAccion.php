<?php

namespace App\Enums;

use ArchTech\Enums\Options;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TipoAccion: string implements HasLabel, HasIcon, HasDescription, HasColor
{

    use Options;

    case entrada = 'entrada';
    case salida = 'salida';
    case update = 'update';
    case delete = 'delete';


    public function getLabel(): ?string
    {
        return $this->name;
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::entrada => 'mdi-content-save-plus',
            self::salida => 'mdi-content-save-move',
            self::update  => 'mdi-content-save-edit',
            self::delete => 'mdi-content-save-minus',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::entrada => 'success',
            self::salida => 'warning',
            self::update => 'gray',
            self::delete => 'danger',
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::entrada => 'This has not finished being written yet.',
            self::salida => 'This is ready for a staff member to read.',
            self::update => 'This has been approved by a staff member and is public on the website.',
            self::delete => 'A staff member has decided this is not appropriate for the website.',
        };
    }
}
