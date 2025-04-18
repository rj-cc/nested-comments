<div class="my-4 p-4 bg-primary-50 rounded-lg ring-gray-100 dark:bg-primary-950 dark:text-white">
    {{ $comment->commentator }}
    <div class="prose max-w-none">
        {!! e(new \Illuminate\Support\HtmlString($this->comment?->body)) !!}
    </div>
</div>
