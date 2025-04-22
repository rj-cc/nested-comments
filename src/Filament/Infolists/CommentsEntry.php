<?php

namespace Coolsam\NestedComments\Filament\Infolists;

use Closure;
use Filament\Infolists\Components\Entry;

class CommentsEntry extends Entry
{
    protected bool | Closure $isLabelHidden = true;

    /**
     * @var view-string
     */
    protected string $view = /** @var view-string */ 'nested-comments::filament.infolists.comments-entry';

    protected array $columnSpan = ['default' => 'full'];
}
