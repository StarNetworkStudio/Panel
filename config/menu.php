<?php
/*
|--------------------------------------------------------------------------
| Sidebar Menus
|--------------------------------------------------------------------------
|
| Register your custom sidebar menu here.
|
*/

$menu['user'] = [
//    ['title' => 'general.dashboard', 'link' => 'user', 'icon' => 'fa-tachometer-alt'],
//    ['title' => 'general.my-closet', 'link' => 'user/closet', 'icon' => 'fa-star'],
//    ['title' => 'general.player-manage', 'link' => 'user/player', 'icon' => 'fa-users'],
//    ['title' => 'general.my-reports', 'link' => 'user/reports', 'icon' => 'fa-flag'],
//    ['title' => 'general.profile', 'link' => 'user/profile', 'icon' => 'fa-user'],
//    [
//        'title' => 'general.developer',
//        'icon' => 'fa-code-branch',
//        'children' => [
//            ['title' => 'general.oauth-manage', 'link' => 'user/oauth/manage', 'icon' => 'fa-feather-alt'],
//        ],
//    ],
];

$menu['admin'] = [
    ['title' => '仪表盘', 'link' => 'admin', 'icon' => 'fa fa-tachometer-alt'],
    ['title' => '用户管理', 'link' => 'admin/users', 'icon' => 'fa fa-users'],
    ['title' => '邀请码管理', 'link' => 'admin/players', 'icon' => 'fa fa-puzzle-piece'],
    ['title' => '系统设置', 'link' => 'admin/options', 'icon' => 'fa fa-cog'],
    //children
/*    [
        'title' => '测试',
        'icon' => 'fa fa-code-branch',
        'children' => [
            ['title' => '测试1', 'link' => 'admin/test', 'icon' => 'fa fa-feather-alt'],
        ],
    ],*/
];

return $menu;
