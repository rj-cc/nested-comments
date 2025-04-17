<?php

namespace Coolsam\NestedComments\Models;

use Coolsam\NestedComments\Concerns\HasReactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Kalnoy\Nestedset\NodeTrait;

class Comment extends Model
{
    use HasReactions;
    use NodeTrait;

    protected $guarded = ['id'];

    public function commentable(): MorphTo
    {
        return $this->morphTo('commentable');
    }
}
