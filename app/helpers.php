<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

if (!function_exists('avatar')) {

    function avatar($email, $size = null)
    {
        $hash = md5(strtolower(trim($email)));

        return gravatar($hash, $size);
    }
}

if (!function_exists('assets')) {

    function assets($relativeUri)
    {
        return url("resources/assets/dist/$relativeUri");
    }
}

if (!function_exists('menu')) {
    function menu($type)
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

            $father_classes = [];
            $Sub_classes = [];
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

}

if (! function_exists('option')) {
    /**
     * Get / set the specified option value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @param  raw    $raw  return raw value without convertion
     * @return mixed
     */
    function option($key = null, $default = null, $raw = false)
    {
        $options = app('options');

        if (is_null($key)) {
            return $options;
        }

        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                $options->set($innerKey, $innerValue);
            }
            return;
        }

        return $options->get($key, $default, $raw);
    }
}

if (! function_exists('option_localized')) {

    function option_localized($key = null, $default = null, $raw = false)
    {
        return option($key.'_'.config('app.locale'), option($key));
    }
}

if (! function_exists('humanize_db_type')) {
    function humanize_db_type($type = null): string
    {
        $map = [
            'mysql'  => 'MySQL/MariaDB',
            'sqlite' => 'SQLite',
            'pgsql'  => 'PostgreSQL',
        ];

        $type = $type ?: config('database.default');

        return Arr::get($map, $type, '');
    }
}

if (! function_exists('get_db_config')) {
    function get_db_config($type = null)
    {
        $type = $type ?: config('database.default');

        return config("database.connections.$type");
    }
}

if (!function_exists('get_datetime_string')) {
    /**
     * Get date time string in "Y-m-d H:i:s" format.
     *
     * @param int $timestamp
     * @return string
     */
    function get_datetime_string($timestamp = 0): string
    {
        return $timestamp == 0 ? Carbon::now()->toDateTimeString() : Carbon::createFromTimestamp($timestamp)->toDateTimeString();
    }
}

if (! function_exists('get_client_ip')) {
    /**
     * Return the client IP address.
     *
     * We define this function because Symfony's "Request::getClientIp()" method
     * needs "setTrustedProxies()", which sucks when load balancer is enabled.
     *
     * @return string
     */
    function get_client_ip(): string
    {
        if (option('ip_get_method') == '0') {
            // Use `HTTP_X_FORWARDED_FOR` if available first
            $ip = Arr::get(
                $_SERVER,
                'HTTP_X_FORWARDED_FOR',
                // Fallback to `HTTP_CLIENT_IP`
                Arr::get(
                    $_SERVER,
                    'HTTP_CLIENT_IP',
                    // Fallback to `REMOTE_ADDR`
                    Arr::get($_SERVER, 'REMOTE_ADDR')
                )
            );
        } else {
            $ip = Arr::get($_SERVER, 'REMOTE_ADDR');
        }

        return $ip;
    }
}

if (! function_exists('is_request_secure')) {
    /**
     * Check whether the request is secure or not.
     * True is always returned when "X-Forwarded-Proto" header is set.
     *
     * We define this function because Symfony's "Request::isSecure()" method
     * needs "setTrustedProxies()" which sucks when load balancer is enabled.
     *
     * @return bool
     */
    function is_request_secure(): bool
    {
        if (Arr::get($_SERVER, 'HTTPS') == 'on') {
            return true;
        }

        if (Arr::get($_SERVER, 'HTTP_X_FORWARDED_PROTO') == 'https') {
            return true;
        }

        if (Arr::get($_SERVER, 'HTTP_X_FORWARDED_SSL') == 'on') {
            return true;
        }

        return false;
    }
}
