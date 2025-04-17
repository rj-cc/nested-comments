<?php

namespace Coolsam\NestedComments\Concerns;

use Coolsam\NestedComments\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(config('nested-comments.models.comment'), 'commentable');
    }

    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->count();
    }

    public function getCommentsTree($offset = null, $limit = null, $columns = ['*'])
    {
        $query = $this->comments()
            ->getQuery()
            ->where('parent_id', '=', null);
        if (filled($offset)) {
            $query->offset($offset);
        }
        if (filled($limit)) {
            $query->limit($limit);
        }

        $columns = ['id', 'parent_id', '_lft', '_rgt', ...$columns];

        return collect($query->get($columns)->map(function (Comment $comment) use ($columns) {
            $descendants = $comment->getDescendants($columns);
            return collect($comment->toArray())->put('descendants', $descendants->toArray());
        })->toArray());
    }

    /**
     * @throws \Exception
     */
    public function addComment(string $comment, mixed $parentId = null)
    {
        $allowGuest = config('nested-comments.allow-guest-comments', false);
        if (! $allowGuest && ! auth()->check()) {
            throw new \Exception('You must be logged in to comment.');
        }

        if ($allowGuest && ! auth()->check()) {
            $userId = null;
        } else {
            $userId = auth()->id();
        }

        return $this->comments()->create([
            'user_id' => $userId,
            'body' => $comment,
            'commentable_id' => $this->getKey(),
            'commentable_type' => $this->getMorphClass(),
            'parent_id' => $parentId,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * @throws \Exception
     */
    public function deleteComment(Comment $comment): ?bool
    {
        if (! auth()->check()) {
            throw new \Exception('You must be logged in to delete your comment.');
        }

        if ($comment->getAttribute('user_id') !== auth()->id()) {
            throw new \Exception('You are not authorized to delete this comment.');
        }

        return $comment->delete();
    }
}
