<?php

namespace Coolsam\NestedComments\Concerns;

use Coolsam\NestedComments\Models\Comment;
use Coolsam\NestedComments\NestedComments;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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

    public function getCommentsTree($offset = null, $limit = null, $columns = ['*']): Collection
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
     * @throws Exception
     */
    public function comment(string $comment, mixed $parentId = null, ?string $name = null)
    {
        $allowGuest = config('nested-comments.allow-guest-comments', false);
        if (! $allowGuest && ! auth()->check()) {
            throw new Exception('You must be logged in to comment.');
        }
        if ($name) {
            app(NestedComments::class)->setGuestName($name);
        }
        $guestId = app(NestedComments::class)->getGuestId();
        $guestName = app(NestedComments::class)->getGuestName();
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
            'guest_id' => $guestId,
            'guest_name' => $guestName,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * @throws Exception
     */
    public function editComment(Comment $comment, string $body, ?string $name = null): ?bool
    {
        $allowGuest = config('nested-comments.allow-guest-comments', false);

        if (! auth()->check() && ! $allowGuest) {
            throw new Exception('You must be logged in to edit your comment.');
        }

        if ($name) {
            app(NestedComments::class)->setGuestName($name);
        }

        if (\auth()->check() && $comment->getAttribute('user_id') !== auth()->id()) {
            throw new Exception('You are not authorized to edit this comment.');
        }

        if ($allowGuest && ! auth()->check()) {
            $guestId = app(NestedComments::class)->getGuestId();
            if ($comment->getAttribute('guest_id') !== $guestId) {
                throw new Exception('You are not authorized to edit this comment.');
            }
        }
        $guestName = app(NestedComments::class)->getGuestName();

        return $comment->update(['body' => $body, 'guest_name' => $guestName, 'ip_address' => request()->ip()]);
    }

    /**
     * @throws Exception
     */
    public function deleteComment(Comment $comment): ?bool
    {
        $allowGuest = config('nested-comments.allow-guest-comments', false);

        if (! auth()->check() && ! $allowGuest) {
            throw new Exception('You must be logged in to edit your comment.');
        }

        if (\auth()->check() && $comment->getAttribute('user_id') !== auth()->id()) {
            throw new Exception('You are not authorized to edit this comment.');
        }

        if ($allowGuest && ! auth()->check()) {
            $guestId = app(NestedComments::class)->getGuestId();
            if ($comment->getAttribute('guest_id') !== $guestId) {
                throw new Exception('You are not authorized to edit this comment.');
            }
        }

        return $comment->delete();
    }
}
