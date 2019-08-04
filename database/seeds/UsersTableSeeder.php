<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'admin';
        $user->email = 'admin@starskim.cn';
        $user->avatar = avatar('admin@starskim.cn');
        $user->ip = '127.0.0.1';
        $user->permission = User::SUPER_ADMIN;
        $user->save();
    }
}
