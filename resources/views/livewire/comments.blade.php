<x-filament::section icon="heroicon-o-chat-bubble-bottom-center-text" class="!ring-0">
    <x-slot name="heading">
        <div class="flex items-center space-x-2">
            <div>
                {{ __('Comments') }}
            </div>
            <div>
                <x-filament::badge color="danger" :title="$this->comments->count()">
                    {{\Illuminate\Support\Number::forHumans($this->comments->count(),maxPrecision: 3, abbreviate: true)}}
                </x-filament::badge>
            </div>
        </div>
    </x-slot>
    <x-slot name="headerEnd">
        <x-filament::button wire:click.prevent="refreshComments()">Refresh</x-filament::button>
    </x-slot>
    @foreach($this->comments as $comment)
        <livewire:nested-comments::comment-card
                :key="$comment->getKey()"
                :comment="$comment" />
    @endforeach
    <livewire:nested-comments::add-comment :commentable="$this->record" />
</x-filament::section>
