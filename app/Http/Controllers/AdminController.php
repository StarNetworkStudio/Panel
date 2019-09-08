<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Option;
use App\Models\User;
use App\Services\OptionForm;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function options()
    {
        $general = Option::form('general', OptionForm::AUTO_DETECT, function ($form) {
            $form->text('site_name');

            $form->text('site_url')
                ->hint()
                ->format(function ($url) {
                    if (ends_with($url, '/')) {
                        $url = substr($url, 0, -1);
                    }

                    if (ends_with($url, '/index.php')) {
                        $url = substr($url, 0, -10);
                    }

                    return $url;
                });

        })->handle(function () {
            Option::set('site_name_' . config('app.locale'), request('site_name'));
        });

        return view('admin.options')
            ->with('forms', compact('general'));
    }

    public function status(Request $request)
    {
        $db = get_db_config();

        return view('admin.status')
            ->with(
                'detail', [
                option_localized('site_name') => [
                    '应用环境' => config('app.env'),
                    '是否处于调试状态' => config('app.debug') ? '是' : '否',
                    'Laravel 版本' => app()->version(),
                ],
                '服务器' => [
                    'PHP 版本' => PHP_VERSION,
                    'Web 服务软件' => $request->server('SERVER_SOFTWARE', '未知'),
                    '操作系统' => sprintf('%s %s %s', php_uname('s'), php_uname('r'), php_uname('m')),
                ],
                '数据库' => [
                    '服务器类型' => humanize_db_type(),
                    '主机' => Arr::get($db, 'host', ''),
                    '端口' => Arr::get($db, 'port', ''),
                    '用户名' => Arr::get($db, 'username'),
                    '数据库' => Arr::get($db, 'database'),
                    '数据表前缀' => Arr::get($db, 'prefix'),
                ],
            ]);
    }

    public function getUserList(Request $request)
    {
        $isSingleUser = $request->has('uid');

        if ($isSingleUser) {
            $users = User::select(['uid', 'email', 'name', 'permission', 'register_at'])
                ->where('uid', intval($request->input('uid')))
                ->get();
        } else {
            $users = User::select(['uid', 'email', 'name', 'permission', 'register_at'])
                ->get();
        }

        return $users;
    }
}
