<?php

namespace Coolsam\NestedComments;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NestedComments
{
    const GUEST_ID_FIELD = 'guest_commentator_id';

    const GUEST_NAME_FIELD = 'guest_commentator_name';

    public function getGuestId(): ?string
    {
        return session(self::GUEST_ID_FIELD);
    }

    public function getGuestName(): string
    {
        if (Auth::check()) {
            return call_user_func(config('nested-comments.closures.getUserNameUsing', fn (Authenticatable | Model $user) => $user->getAttribute('name')), Auth::user());
        }

        return session(self::GUEST_NAME_FIELD, 'Guest');
    }

    public function setGuestName(string $name): void
    {
        session([self::GUEST_NAME_FIELD => $name]);
    }

    public function setOrGetGuestId()
    {
        $id = Str::ulid()->toString();
        if (! session()->has(self::GUEST_ID_FIELD)) {
            session([self::GUEST_ID_FIELD => $id]);
        }

        return session(self::GUEST_ID_FIELD);
    }

    public function setOrGetGuestName()
    {
        if (! session()->has(self::GUEST_NAME_FIELD)) {
            session([self::GUEST_NAME_FIELD => 'Guest']);
        }

        return session(self::GUEST_NAME_FIELD);
    }
}
