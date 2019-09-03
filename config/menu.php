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
    ['title' => '用户管理', 'link' => 'admin/users', 'icon' => 'fa fa-users'],
//    ['title' => '邀请码管理', 'link' => 'admin/invite', 'icon' => 'fa fa-puzzle-piece'],
    ['title' => '系统设置', 'link' => 'admin/options', 'icon' => 'fa fa-cog'],
    ['title' => '系统运行日志', 'link' => 'admin/logs', 'icon' => 'fa fa-cubes'],
];

return $menu;
