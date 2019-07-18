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
        return [
            [
                'id'=>1,
                'employee_id'=>"463978155-5",
                'first_name'=>"Carroll",
                'last_name'=>"Maharry",
                'email'=>"cmaharry0@topsy.com",
                'phone'=>"420-935-0970",
                'gender'=>"Male",
                'department'=>"Legal",
                'address'=>"72460 Bunting Trail",
                'hire_date'=>"3/18/2018",
                'website'=>"https://gmpg.org",
                'notes'=>"euismod scelerisque quam turpis adipiscing lorem vitae mattis nibh ligula nec sem duis",
                'status'=>6,
                'type'=>1,
                'salary'=>"$339.37"
            ]
        ];
    }
}
