<div>
    <div class="my-4 p-4 bg-primary-50 rounded-lg ring-gray-100 dark:bg-gray-950">
        {{ $comment->commentator }}
        <div class="prose max-w-none dark:prose-invert">
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
        <div class="ms-8 border-r">
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
