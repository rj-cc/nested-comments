<x-filament::section icon="heroicon-o-chat-bubble-bottom-center-text" class="!ring-0">
    <x-slot name="heading">
        {{ __('Comments') }}
    </x-slot>
    <x-slot name="headerEnd">
        <x-filament::button wire:click.prevent="refreshComments()">Refresh</x-filament::button>
    </x-slot>
    <livewire:nested-comments::add-comment :commentable="$this->record" />
    @foreach($this->comments as $comment)
        <livewire:nested-comments::comment-card
                :key="$comment->getKey()"
                :comment="$comment" />
    @endforeach
</x-filament::section>
