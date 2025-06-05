<?php

namespace Coolsam\NestedComments\Livewire;

use Coolsam\NestedComments\Models\Comment;
use Coolsam\NestedComments\NestedCommentsServiceProvider;
use Livewire\Component;

class CommentCard extends Component
{
    public ?Comment $comment = null;

    public bool $showReplies = false;

    public ?\Closure $getUserNameUsing = null;

    public ?\Closure $getUserAvatarUsing = null;

    protected $listeners = [
        'refresh' => 'refreshReplies',
    ];

    public function mount(?Comment $comment = null, ?\Closure $getUserNameUsing = null, ?\Closure $getUserAvatarUsing = null): void
    {
        if (! $comment) {
            throw new \Error('The $comment property is required.');
        }

        $this->comment = $comment;

        $this->getUserNameUsing = $getUserNameUsing ?? fn ($user) => $user->getAttribute('name');
        $this->getUserAvatarUsing = $getUserAvatarUsing ?? fn ($user) => app(\Coolsam\NestedComments\NestedComments::class)->getDefaultUserAvatar($user);
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
        $this->showReplies = ! $this->showReplies;
    }

    public function getAvatar()
    {
        if (! $this->comment) {
            return '';
        }

        return call_user_func($this->getUserAvatarUsing, $this->comment->commentator);
    }

    public function getCommentator(): string
    {
        if (! $this->comment) {
            return '';
        }
        if (! $this->comment->user) {
            return $this->comment->getAttribute('guest_name') ?? 'Guest';
        }

        return call_user_func($this->getUserNameUsing, $this->comment->user);
    }
}
