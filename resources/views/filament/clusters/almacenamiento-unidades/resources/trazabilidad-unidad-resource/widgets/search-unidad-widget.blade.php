<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Buscar Unidad transfusional
        </x-slot>

        <div class="mt-5 md:mt-0 md:col-span-2">

            <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow {{ isset($actions) ? ' sm:rounded-tl-md
                        sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $this->form }}

                    <x-filament::button id="btnSearch" label="search" type="button" icon="heroicon-m-plus-circle"
                        wire:loading.attr="disabled" wire:key="btnSearch">
                        Mostrar trazabilidad
                    </x-filament::button>
                </div>
            </div>


            @if (isset($actions))
            <div class=" flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-6 shadow
                                sm:rounded-bl-md sm:rounded-br-md">
                {{ $actions }}
            </div>
            @endif


        </div>
    </x-filament::section>
</x-filament-widgets::widget>