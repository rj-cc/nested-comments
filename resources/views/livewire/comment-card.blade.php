<div wire:poll.15s>
    <div class="my-4 p-4 bg-primary-50 rounded-lg ring-gray-100 dark:bg-gray-950">
        <div class="flex flex-wrap items-center justify-between">
            <div x-data="{showFullDate: false}" class="flex items-center space-x-2">
                <x-filament::avatar
                        :src="$this->getAvatar()"
                        :alt="$this->comment->commentator"
                        :name="$this->comment->commentator"
                        size="md"
                        :circular="false"
                />
                <div x-on:click="showFullDate = !showFullDate" title="{{__('Show full date')}}" class="cursor-pointer">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $this->comment->user?->name }}
                    </p>
                    <p x-show="!showFullDate"
                       class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $this->comment->created_at?->diffForHumans() }}
                    </p>
                    <p x-show="showFullDate"
                       class="text-xs text-gray-500 dark:text-gray-400"
                    >{{ $this->comment->created_at->format('F j Y h:i:s A') }}</p>
                </div>
            </div>
        </div>
        <div class="prose my-4 max-w-none dark:prose-invert">
            {!! e(new \Illuminate\Support\HtmlString($this->comment?->body)) !!}
        </div>
        <div class="flex flex-wrap items-center space-x-2">
            <x-filament::link
                    size="xs"
                    class="cursor-pointer"
                    icon="heroicon-o-arrow-uturn-left"
                    wire:click.prevent="toggleReplies">
                {{$this->comment->replies_count}} {{ str('Reply')->plural($this->comment->replies_count) }} {{$this->showReplies ? ' - Hide' : ' - Show'}}
            </x-filament::link>
        </div>
    </div>
    @if($showReplies)
        <div class="pl-8 border-l my-2">
            @foreach($this->comment->children as $reply)
                <livewire:nested-comments::comment-card
                        :key="$reply->getKey()"
                        :comment="$reply" />
            @endforeach
            <livewire:nested-comments::add-comment
                    :key="$comment->getKey()"
                    :commentable="$comment->commentable"
                    :reply-to="$comment"
                    :adding-comment="false"
                    wire:loading.attr="disabled"
            />
        </div>
    @endif
</div>