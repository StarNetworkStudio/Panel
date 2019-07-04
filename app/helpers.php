<?php


use Illuminate\Support\Arr;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function assets($relativeUri)
{
    return url("dist/$relativeUri");
}

if (!function_exists('panel_menu')) {
    function panel_menu($type)
    {
        $menu = config('menu');

        switch ($type) {
            case 'user':
                event(new App\Events\ConfigureUserMenu($menu));
                break;
            case 'admin':
                event(new App\Events\ConfigureAdminMenu($menu));
                break;
        }

        if (!isset($menu[$type])) {
            throw new InvalidArgumentException;
        }

        return panel_menu_render($menu[$type]);
    }

    function panel_menu_render($data)
    {
        $content = '';

        foreach ($data as $key => $value) {
            $active = app('request')->is(@$value['link']);

            // also set parent as active if any child is active
            foreach ((array)@$value['children'] as $childKey => $childValue) {
                if (app('request')->is(@$childValue['link'])) {
                    $active = true;
                }
            }

            $father_classes=[];
            $Sub_classes =[];
            $active ? ($father_classes[] = 'kt-menu__item--active') : null;
            $active ? ($Sub_classes[] = 'kt-menu__item--open kt-menu__item--here') : null;
            if (isset($value['children'])) {
                $attr = count($Sub_classes) ? sprintf('%s', implode(' ', $Sub_classes)) : '';
                $content .= "<li class='kt-menu__item kt-menu__item--submenu {$attr}' aria-haspopup='true' data-ktmenu-submenu-toggle='hover'>";
                $content .= sprintf(
                    '<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon %s"></i>
                    <span class="kt-menu__link-text">%s</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                    ',
                    $value['icon'],
                    trans($value['title'])
                );

                // recurse
                $content .= sprintf(
                        '<div class="kt-menu__submenu ">
                    <span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                    <li class="kt-menu__item kt-menu__item--parent" aria-haspopup="true">
                    <span class="kt-menu__link">
                    <span class="kt-menu__link-text">%s</span>
                    </span>
                    </li>',
                        trans($value['title'])
                    ) . panel_menu_children($value) .
                    '</ul>
                    </div>';
            } else {
                if ($value) {
                    $attr = count($father_classes) ? sprintf('%s', implode(' ', $father_classes)) : '';
                    $content .= "<li class='kt-menu__item {$attr}' aria-haspopup='true'>";
                    $content .= sprintf(
                        '<a href="%s" class="kt-menu__link">
                            <i class="kt-menu__link-icon %s"></i>
                            <span class="kt-menu__link-text">%s</span>
                            </a>',
                        url((string)$value['link']),
                        (string)$value['icon'],
                        trans((string)$value['title'])
                    );
                }
            }
            $content .= '</li>';
        }
        return $content;
    }

    //子菜单
    function panel_menu_children($data)
    {
        $content = '';
        foreach ((array)@$data['children'] as $childKey => $childValue) {
            $active = app('request')->is(@$childValue['link']);
            $classes = [];
            $active ? ($classes[] = 'kt-menu__item--active') : null;
            $attr = count($classes) ? sprintf('%s', implode(' ', $classes)) : '';
            $content .= "<li class='kt-menu__item {$attr}' aria-haspopup='true'>";
            if ($childValue) {
                $content .= sprintf(
                    '<a href="%s" class="kt-menu__link">
                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
                    <span></span>
                    </i>
                    <span class="kt-menu__link-text">%s</span>
                    </a>',
                    url((string)$childValue['link']),
                    trans((string)$childValue['title'])
                );
            }
            $content .= '</li>';
        }
        return $content;
    }

    //BUG没修版
    /*function panel_menu_render($data)
    {
        $content = '';

        foreach ($data as $key => $value) {
            $active = app('request')->is(@$value['link']);

            // also set parent as active if any child is active
            foreach ((array)@$value['children'] as $childKey => $childValue) {
                if (app('request')->is(@$childValue['link'])) {
                    $active = true;
                }
            }

            $classes = [];
            $active ? ($classes[] = 'kt-menu__item--active') : $classes[] = null;
            isset($value['children']) ? ($classes[] = 'kt-menu__item--submenu') : $classes[] = null;
            isset($value['children']) ? ($classes[] = 'data-ktmenu-submenu-toggle="hover"') : null;

            // $attr = count($classes) ? sprintf(' class="%s"', implode(' ', $classes)) : '';
            $attr = count($classes) ? sprintf('class="kt-menu__item %s" aria-haspopup="true" ', $classes[0]) : '';
            $submenu = count($classes) ? sprintf('%s', $classes[1]) : '';

            $content .= "<li {$attr}{$submenu}>";

            if (isset($value['children'])) {
                $content .= sprintf(
                    '<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon %s"></i>
                    <span class="kt-menu__link-text">%s</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                    ',
                    $value['icon'],
                    trans($value['title'])
                );

                // recurse
                $content .= sprintf(
                        '<div class="kt-menu__submenu " style="" kt-hidden-height="80">
                    <span class="kt-menu__arrow"></span><ul class="kt-menu__subnav">
                    <li class="kt-menu__item kt-menu__item--parent" aria-haspopup="true">
                    <span class="kt-menu__link">
                    <span class="kt-menu__link-text">%s</span>
                    </span>
                    </li>',
                        trans($value['title'])
                    ) . panel_menu_render($value['children']) .
                    '</ul></div>';
            } else {
                if ($value) {
                    $content .= sprintf(
                        '<a href="%s" class="kt-menu__link">
                        <i class="kt-menu__link-icon %s"></i>
                        <span class="kt-menu__link-text">%s</span>
                        </a>',
                        url((string)$value['link']),
                        (string)$value['icon'],
                        trans((string)$value['title'])
                    );
                }
            }

            $content .= '</li>';
        }

        return $content;
    }*/
}
