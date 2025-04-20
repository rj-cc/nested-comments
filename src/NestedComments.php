<?php

namespace Coolsam\NestedComments;

use Filament\AvatarProviders\UiAvatarsProvider;
use Filament\Support\Facades\FilamentColor;
use FilamentTiptapEditor\Data\MentionItem;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Color\Rgb;

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
            return call_user_func(config('nested-comments.closures.getUserNameUsing',
                fn(Authenticatable|Model $user) => $user->getAttribute('name')), Auth::user());
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
        if (!session()->has(self::GUEST_ID_FIELD)) {
            session([self::GUEST_ID_FIELD => $id]);
        }

        return session(self::GUEST_ID_FIELD);
    }

    public function setOrGetGuestName()
    {
        if (!session()->has(self::GUEST_NAME_FIELD)) {
            session([self::GUEST_NAME_FIELD => 'Guest']);
        }

        return session(self::GUEST_NAME_FIELD);
    }

    public function classHasTrait(object|string $classInstance, string $trait): bool
    {
        return in_array($trait, class_uses_recursive($classInstance));
    }

    public function geDefaultUserAvatar(Authenticatable|Model|string $user)
    {
        if (is_string($user)) {
            $name = str($user)
                ->trim()
                ->explode(' ')
                ->map(fn(string $segment): string => filled($segment) ? mb_substr($segment, 0, 1) : '')
                ->join(' ');

            $backgroundColor = Rgb::fromString('rgb('.FilamentColor::getColors()['gray'][950].')')->toHex();

            return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=FFFFFF&background='.str($backgroundColor)->after('#');
        } else {
            return app(UiAvatarsProvider::class)->get($user);
        }
    }

    public function getUserMentions(string $query)
    {
        $userModel = config('nested-comments.models.user', config('auth.providers.users.model', 'App\\Models\\User'));

        return $userModel::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->take(20)
            ->get()
            ->map(function ($user) {
                return new MentionItem(
                    id: $user->getKey(),
                    label: call_user_func(config('nested-comments.closures.getUserNameUsing'), $user),
                    image: call_user_func(config('nested-comments.closures.getUserAvatarUsing'), $user),
                    roundedImage: true,
                );
            })->toArray();
    }

    public function getCurrentThreadUsers(string $searchQuery, Model $commentable)
    {
        $userModel = config('nested-comments.models.user', config('auth.providers.users.model', 'App\\Models\\User'));
        $ids = $commentable->comments()->pluck('user_id')->filter()->unique()->toArray();

        return $userModel::query()
            ->whereIn('id', $ids)
            ->where(fn($q) => $q
                ->where('name', 'like', "%{$searchQuery}%")
                ->orWhere('email', 'like', "%{$searchQuery}%")
            )
            ->take(20)
            ->get()
            ->map(function ($user) {
                return new MentionItem(
                    id: $user->getKey(),
                    label: call_user_func(config('nested-comments.closures.getUserNameUsing'), $user),
                    image: call_user_func(config('nested-comments.closures.getUserAvatarUsing'), $user),
                    roundedImage: true,
                );
            })->toArray();
    }
}
