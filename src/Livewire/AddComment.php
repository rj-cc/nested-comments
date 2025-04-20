<?php

namespace Coolsam\NestedComments\Livewire;

use Coolsam\NestedComments\Models\Comment;
use Coolsam\NestedComments\NestedComments;
use Coolsam\NestedComments\NestedCommentsServiceProvider;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use FilamentTiptapEditor\Concerns\HasFormMentions;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

/**
 * @property Form $form
 */
class AddComment extends Component implements HasForms
{
    use HasFormMentions;
    use InteractsWithForms;

    public ?array $data = [];

    public bool $addingComment = false;

    public ?Model $commentable = null;

    public ?Comment $replyTo = null;

    public function mount(?Model $commentable = null, ?Comment $replyTo = null): void
    {
        if (! $commentable) {
            throw new \Error('The $commentable property is required.');
        }
        $this->commentable = $commentable;
        $this->replyTo = $replyTo;
        $this->form->fill();
    }

    public function getCommentable(): Model
    {
        if (! $this->commentable) {
            throw new \Error('The $commentable property is required.');
        }

        return $this->commentable;
    }

    public function form(Form $form): Form
    {
        $mentionsClosure = config('nested-comments.closures.getMentionsUsing', fn (string $query, Model $commentable) => app(NestedComments::class)->getUserMentions($query));

        return $form
            ->schema([
                TiptapEditor::make('body')
                    ->label(__('Your comment'))
                    ->profile('minimal')
                    ->extraInputAttributes(['style' => 'min-height: 12rem;'])
                    ->getMentionItemsUsing(fn (string $query) => $mentionsClosure($query, $this->getCommentable()))
                    ->required()
                    ->autofocus(),
            ])
            ->statePath('data')
            ->model(config('nested-comments.models.comment', Comment::class));
    }

    /**
     * @throws \Exception
     */
    public function create(): void
    {
        $data = $this->form->getState();

        $commentable = $this->getCommentable();

        /**
         * @phpstan-ignore-next-line
         */
        $record = $commentable->comment(comment: $data['body'], parentId: $this->replyTo?->getKey());
        $this->dispatch('refresh');
        $this->showForm(false);
    }

    public function render(): View
    {
        $namespace = NestedCommentsServiceProvider::$viewNamespace;

        return view("$namespace::livewire.add-comment");
    }

    public function showForm(bool $adding): void
    {
        $this->form->fill();
        $this->addingComment = $adding;
    }
}
