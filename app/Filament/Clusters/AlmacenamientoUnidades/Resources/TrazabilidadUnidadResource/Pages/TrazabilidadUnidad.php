<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Pages;

use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource;
use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Widgets\SearchUnidadWidget;
use App\Models\KardexUnidad;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Concerns\InteractsWithRecords;
use Illuminate\Support\Facades\Log;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use JaOcero\ActivityTimeline\Enums\IconAnimation;
use JaOcero\ActivityTimeline\Pages\ActivityTimelinePage;

class TrazabilidadUnidad extends ListRecords

{

    protected static string $resource = TrazabilidadUnidadResource::class;

    protected static string $view = 'filament.clusters.almacenamiento-unidades.resources.trazabilidad-unidad-resource.pages.trazabilidad-unidad';

    public static function getWidgets(): array
    {
        return [
            SearchUnidadWidget::class,

        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SearchUnidadWidget::class,

        ];
    }
}
