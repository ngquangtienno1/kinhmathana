<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;


class UserController extends Controller
{
    public function index(){
        $users = User::get();
        return view('admin.users.list', compact('users'));
    }
}
