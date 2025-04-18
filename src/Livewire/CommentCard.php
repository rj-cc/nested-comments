<?php

namespace Coolsam\NestedComments\Livewire;

use Coolsam\NestedComments\Models\Comment;
use Coolsam\NestedComments\NestedCommentsServiceProvider;
use Livewire\Component;

class CommentCard extends Component
{
    public ?Comment $comment = null;

    public bool $showReplies = false;

    protected $listeners = [
        'refresh'=> 'refreshReplies'
    ];

    public function mount(?Comment $comment = null): void
    {
        if (! $comment) {
            throw new \Error('The $comment property is required.');
        }

        $this->comment = $comment;
    }

    public function render()
    {
        $namespace = NestedCommentsServiceProvider::$viewNamespace;
        return view("$namespace::livewire.comment-card");
    }

    public function refreshReplies(): void
    {
        $this->comment = $this->comment?->refresh();
    }

    public function toggleReplies(): void
    {
        $this->showReplies = !$this->showReplies;
    }
}
