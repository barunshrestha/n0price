<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/',
            'new-tab' => false,
        ],

        [
            'section' => 'Portfolio',
        ],

        [
            'title' => 'Manage Portfolio',
            'root' => true,
            'page'=>'/portfolio',
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'new-tab' => false,
        ],
        [
            'section' => 'Settings',
        ],

        [
            'title' => 'Logout',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/logout',
            'new-tab' => false,
        ],

    ]
];