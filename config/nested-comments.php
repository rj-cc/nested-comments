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

    'guest-comments' => env('ALLOW_GUEST_COMMENTS', false), // Allow guest users to comment
];
