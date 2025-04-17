<?php

return [
    'tables' => [
        'comments' => 'comments',
        'reactions' => 'reactions',
        'users' => 'users', // The table that will be used to get the authenticated user
    ],

    'models' => [
        'comment' => \Coolsam\NestedComments\Models\Comment::class,
        'reaction' => \Coolsam\NestedComments\Models\Reaction::class,
        'user' => env( 'AUTH_MODEL', 'App\Models\User'), // The model that will be used to get the authenticated user
    ],

    'policies' => [
        'comment' => null,
        'reaction' => null,
    ],
    'allowed-reactions' => [
        '👍', // thumbs up
        '👎', // thumbs down
        '❤️', // heart
        '😂', // laughing
        '😮', // surprised
        '😢', // crying
        '😡', // angry
        '🔥', // fire
        '🎉', // party popper
        '🚀', // rocket
    ],
    'allow-multiple-reactions' => env('ALLOW_MULTIPLE_REACTIONS', false), // Allow multiple reactions from the same user
    'allow-guest-reactions' => env('ALLOW_GUEST_REACTIONS', false), // Allow guest users to react
    'allow-guest-comments' => env('ALLOW_GUEST_COMMENTS', false), // Allow guest users to comment
];
