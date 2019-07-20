<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function options()
    {
        return view('admin.options');
    }

    public function getUserList(Request $request)
    {
        $isSingleUser = $request->has('uid');

        if ($isSingleUser) {
            $users = User::select(['uid', 'email', 'name', 'register_at'])
                ->where('uid', intval($request->input('uid')))
                ->get();
        } else {
            $users = User::select(['uid', 'email', 'name', 'register_at'])
                ->get();
        }

        return $users;
    }
}
