<?php

namespace Coolsam\NestedComments\Filament\Infolists;

use Closure;
use Filament\Infolists\Components\Entry;

class CommentsEntry extends Entry
{
    protected bool | Closure $isLabelHidden = true;

    protected string $view = 'nested-comments::filament.infolists.comments-entry';
    protected array $columnSpan = ['default' => 'full'];
}
