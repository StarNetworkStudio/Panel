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
            $page = $request->input('page', 1);
            $pages = $request->input('pages', 1);
            $perPage = $request->input('perPage', -1);
            $search = $request->input('search', '');
            $sortType = $request->input('sort.sort', 'asc');
            $sortField = $request->input('sort.field', 'uid');

            $users = User::select(['uid', 'email', 'name', 'register_at'])
                ->where('uid', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orderBy($sortField, $sortType)
                ->get();
        }

        return [
            'meta' => [
                'page' => $page,
                'pages' => $pages,
                'perpage' => $perPage,
                'sort' => $sortType,
                'field' => $sortField,
            ],
            'data' => $users,
        ];
    }

    public function getUserLists(Request $request)
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
