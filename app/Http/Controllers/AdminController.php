<?php

namespace App\Http\Controllers;

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
        })->handle(function () {
            Option::set('site_name_'.config('app.locale'), request('site_name'));
        });

        return view('admin.options')
            ->with('forms', compact('general'));
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
