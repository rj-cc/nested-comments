<?php

namespace Coolsam\NestedComments\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Coolsam\NestedComments\NestedComments
 */
class NestedComments extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Coolsam\NestedComments\NestedComments::class;
    }
}
