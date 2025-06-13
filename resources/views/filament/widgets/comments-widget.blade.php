<x-filament-widgets::widget>
    @if($this->record)
        <livewire:nested-comments::comments :record="$this->record" />
    @else
        <x-filament::section>
            {{ __('nested-comments::nested-comments.comments.general.no_commentable_record_found_widget') }}
        </x-filament::section>
    @endif
</x-filament-widgets::widget>
