<?php

namespace Coolsam\NestedComments\Filament\Infolists;

use Closure;
use Filament\Infolists\Components\RepeatableEntry;

class CommentsPanel extends RepeatableEntry
{
    protected string $view = 'nested-comments::filament.infolists.comments-panel';

    protected bool | Closure $isContained = false;
    protected array $columnSpan = ['default' => 'full'];

    public static function make(?string $name = null): static
    {
        $name = $name ?? 'comments';
        return parent::make($name);
    }
}
