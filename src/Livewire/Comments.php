<?php

namespace Coolsam\NestedComments\Livewire;

use Coolsam\NestedComments\Concerns\HasComments;
use Coolsam\NestedComments\Models\Comment;
use Coolsam\NestedComments\NestedComments;
use Coolsam\NestedComments\NestedCommentsServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;

class Comments extends Component
{
    /**
     * @var (Model&HasComments)|null
     */
    public ?Model $record = null;

    protected $listeners = [
        'refresh' => 'refreshComments',
    ];

    /**
     * @var Collection<Comment>
     */
    public Collection $comments;

    public ?\Closure $getMentionsUsing = null;

    public ?\Closure $getUserAvatarUsing = null;

    public ?\Closure $getUserNameUsing = null;

    public function mount(
        \Closure|null $getMentionsUsing = null,
        \Closure|null $getUserAvatarUsing = null,
        \Closure|null $getUserNameUsing = null): void
    {
        $this->comments = collect();
        $this->getMentionsUsing = $getMentionsUsing;
        $this->getUserAvatarUsing = $getUserAvatarUsing;
        $this->getUserNameUsing = $getUserNameUsing;

        if (! $this->record) {
            throw new \Error('Record model (Commentable) is required');
        }

        if (! app(NestedComments::class)->classHasTrait($this->record, HasComments::class)) {
            throw new \Error('Record model must use the HasComments trait');
        }

        $this->refreshComments();
    }

    public function refreshComments(): void
    {
        $this->record = $this->record->refresh();
        if (method_exists($this->record, 'getCommentsTree')) {
            $this->comments = $this->record->getCommentsTree();
        }
    }

    public function render()
    {
        $namespace = NestedCommentsServiceProvider::$viewNamespace;

        return view($namespace . '::livewire.comments');
    }

    public function getMentionsUsingClosure()
    {
        return $this->getMentionsUsing;
    }

    public function getUserAvatarUsingClosure()
    {
        return $this->getUserAvatarUsing;
    }

    public function getUserNameUsingClosure()
    {
        return $this->getUserNameUsing;
    }
}
