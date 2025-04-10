<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Pages;

use App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource;
use App\Models\KardexUnidad;
use Filament\Actions;
use Filament\Actions\Concerns\HasInfolist;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use JaOcero\ActivityTimeline\Enums\IconAnimation;

class TimeLineUnidad extends ViewRecord
{

    protected static string $resource = TrazabilidadUnidadResource::class;

  
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record(KardexUnidad::find(9))
            ->schema([
                ActivitySection::make('activities')
                    ->label('My Activities')
                    ->description('These are the activities that have been recorded.')
                    ->schema([
                        ActivityTitle::make('title')
                            ->placeholder('No title is set')
                            ->allowHtml(), // Be aware that you will need to ensure that the HTML is safe to render, otherwise your application will be vulnerable to XSS attacks.
                        ActivityDescription::make('description')
                            ->placeholder('No description is set')
                            ->allowHtml(),
                        ActivityDate::make('created_at')
                            ->date('F j, Y', 'Asia/Manila')
                            ->placeholder('No date is set.'),
                        ActivityIcon::make('status')
                            ->icon(fn(string | null $state): string | null => match ($state) {
                                'ideation' => 'heroicon-m-light-bulb',
                                'drafting' => 'heroicon-m-bolt',
                                'reviewing' => 'heroicon-m-document-magnifying-glass',
                                'published' => 'heroicon-m-rocket-launch',
                                default => null,
                            })
                            /*
                            You can animate icon with ->animation() method.
                            Possible values : IconAnimation::Ping, IconAnimation::Pulse, IconAnimation::Bounce, IconAnimation::Spin or a Closure
                         */
                            ->animation(IconAnimation::Ping)
                            ->color(fn(string | null $state): string | null => match ($state) {
                                'ideation' => 'purple',
                                'drafting' => 'info',
                                'reviewing' => 'warning',
                                'published' => 'success',
                                default => 'gray',
                            }),
                    ])
                    ->showItemsCount(2) // Show up to 2 items
                    ->showItemsLabel('View Old') // Show "View Old" as link label
                    ->showItemsIcon('heroicon-m-chevron-down') // Show button icon
                    ->showItemsColor('gray') // Show button color and it supports all colors
                    ->aside(true)
                    ->headingVisible(true) // make heading visible or not
                    ->extraAttributes(['class' => 'my-new-class']) // add extra class
            ]);
    }
}
