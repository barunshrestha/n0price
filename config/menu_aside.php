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


        // Custom
        [
            'section' => 'User',
        ],
        [
            'title' => 'Users',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/users',
            'root' => true,
            'new-tab' => false,
        ],
        [
            'section' => 'Coin',
        ],
        [
            'title' => 'Coin',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page' => '/coins',
            'root' => true,
            'new-tab' => false,
        ],
        [
            'title' => 'Transaction',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'page'=>'/all/transactions',
            'root' => true,
            
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
