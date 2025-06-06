<?php

namespace Coolsam\NestedComments\Filament\Infolists;

use Closure;
use Filament\Infolists\Components\Entry;

class CommentsEntry extends Entry
{
    protected bool | Closure $isLabelHidden = true;

    /** @phpstan-ignore-next-line */
    protected string $view = 'nested-comments::filament.infolists.comments-entry';

    protected array $columnSpan = ['default' => 'full'];

    public Closure | string | null $userNameUsingClosure = null;
    public Closure | string | null $userAvatarUsingClosure = null;
    public Closure | string | null $mentionsUsingClosure = null;

    public function getUserNameUsing(Closure | string | null $callback = null): static
    {
        $this->userNameUsingClosure = $callback;

        return $this;
    }

    public function getUserAvatarUsing(Closure | string | null $callback = null): static
    {
        $this->userAvatarUsingClosure = $callback;

        return $this;
    }

    public function getMentionsUsing(Closure | string | null $callback = null): static
    {
        $this->mentionsUsingClosure = $callback;

        return $this;
    }

    public function getMentionsUsingClosure(): ?Closure
    {
        return $this->mentionsUsingClosure;
    }

    public function getUserNameUsingClosure(): ?Closure
    {
        return $this->userNameUsingClosure;
    }

    public function getUserAvatarUsingClosure(): ?Closure
    {
        return $this->userAvatarUsingClosure;
    }
}
