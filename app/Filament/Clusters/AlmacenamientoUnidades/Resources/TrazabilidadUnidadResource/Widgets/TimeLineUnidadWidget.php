<?php

namespace App\Filament\Clusters\AlmacenamientoUnidades\Resources\TrazabilidadUnidadResource\Widgets;

use App\Models\KardexUnidad;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Widgets\Widget;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use JaOcero\ActivityTimeline\Enums\IconAnimation;

class TimeLineUnidadWidget extends Widget 
{

    public ?array $data = [];
    protected static string $view = 'filament.clusters.almacenamiento-unidades.resources.trazabilidad-unidad-resource.widgets.time-line-unidad-widget';


    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;

    protected static ?string $pollingInterval = null;

    protected function configuration(): array
    {
        return [
            'activity_section' => [
                'label' => 'Activities', // label for the section
                'description' => 'These are the activities that have been recorded.', // description for the section
                'show_items_count' => 0, // show the number of items to be shown
                'show_items_label' => 'Show more', // show button label
                'show_items_icon' => 'heroicon-o-chevron-down', // show button icon,
                'show_items_color' => 'gray', // show button color,
                'aside' => true, // show the section in the aside
                'empty_state_heading' => 'No activities yet', // heading for the empty state
                'empty_state_description' => 'Check back later for activities that have been recorded.', // description for the empty state
                'empty_state_icon' => 'heroicon-o-bolt-slash', // icon for the empty state
                'heading_visible' => true, // show the heading
                'extra_attributes' => [], // extra attributes


            ],
            'activity_title' => [
                'placeholder' => 'No title is set', // this will show when there is no title
                'allow_html' => true, // set true to allow html in the title

                /**
             * You are free to adjust the state before displaying it on your page.
             * Take note that the state returns these data below:
             *      [
             *       'log_name' => $activity->log_name,
             *      'description' => $activity->description,
             *      'subject' => $activity->subject,
             *      'event' => $activity->event,
             *      'causer' => $activity->causer,
             *      'properties' => json_decode($activity->properties, true),
             *      'batch_uuid' => $activity->batch_uuid,
             *     ]

             * If you wish to make modifications, please refer to the default code in the HasSetting trait.
             */

                // 'modify_state' => function (array $state) {
                //
                // }

            ],
            'activity_description' => [
                'placeholder' => 'No description is set', // this will show when there is no description
                'allow_html' => true, // set true to allow html in the description

                /**
             * You are free to adjust the state before displaying it on your page.
             * Take note that the state returns these data below:
             *      [
             *       'log_name' => $activity->log_name,
             *      'description' => $activity->description,
             *      'subject' => $activity->subject,
             *      'event' => $activity->event,
             *      'causer' => $activity->causer,
             *      'properties' => json_decode($activity->properties, true),
             *      'batch_uuid' => $activity->batch_uuid,
             *     ]

             * If you wish to make modifications, please refer to the default code in the HasSetting trait.
             */

                // 'modify_state' => function (array $state) {
                //
                // }

            ],
            'activity_date' => [
                'name' => 'created_at', // or updated_at
                'date' => 'F j, Y g:i A', // date format
                'placeholder' => 'No date is set', // this will show when there is no date
                'modify_state' => fn(string | null $state): string | null => match ($state) {
                    /**
                     * 'event_name' => 'heroicon-o-calendar',
                     * ... and more
                     */
                    default => null
                },
            ],
            'activity_icon' => [
                'icon' => fn(string | null $state): string | null => match ($state) {
                    /**
                     * 'event_name' => 'heroicon-o-calendar',
                     * ... and more
                     */
                    default => null
                },
                'color' => fn(string | null $state): string | null => match ($state) {
                    /**
                     * 'event_name' => 'primary',
                     * ... and more
                     */
                    default => null
                },

            ],

        ];
    }

    public function activityInfolist(Infolist $infolist): Infolist
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
