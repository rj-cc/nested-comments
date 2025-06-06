<?php

namespace Coolsam\NestedComments\Livewire;

use Coolsam\NestedComments\Models\Comment;
use Coolsam\NestedComments\NestedCommentsServiceProvider;
use Error;
use Filament\Support\Concerns\EvaluatesClosures;
use Livewire\Component;

class CommentCard extends Component
{
    use EvaluatesClosures;

    public ?Comment $comment = null;

    public bool $showReplies = false;

    public ?string $userAvatar = null;

    public ?string $userName = null;

    protected $listeners = [
        'refresh' => 'refreshReplies',
    ];

    public function mount(?Comment $comment = null): void
    {
        if (! $comment) {
            throw new Error('The $comment property is required.');
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
        $this->showReplies = ! $this->showReplies;
    }

    public function getAvatar()
    {
        if (! $this->comment) {
            return '';
        }

        /**
         * @phpstan-ignore-next-line
         */
        return $this->comment->commentable?->getUserAvatarUsing($this->comment);
    }

    public function getCommentator(): string
    {
        if (! $this->comment) {
            return '';
        }

        /**
         * @phpstan-ignore-next-line
         */
        return $this->comment->commentable?->getUserNameUsing($this->comment);
    }
}
