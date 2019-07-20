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
    ['title' => '仪表盘', 'link' => 'user', 'icon' => 'fa fa-tachometer-alt'],
];

$menu['admin'] = [
    ['title' => '仪表盘', 'link' => 'admin', 'icon' => 'fa fa-tachometer-alt'],
    ['title' => '用户管理v1', 'link' => 'admin/users-v1', 'icon' => 'fa fa-users'],
    ['title' => '用户管理v2', 'link' => 'admin/users-v2', 'icon' => 'fa fa-users'],
    ['title' => '邀请码管理', 'link' => 'admin/players', 'icon' => 'fa fa-puzzle-piece'],
    ['title' => '系统设置', 'link' => 'admin/options', 'icon' => 'fa fa-cog'],
];

return $menu;
