<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Models\User;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewUsers()
    {
        $users = User::get()->all();
        return view('viewUsers', compact('users'));
    }

    public function updateUser(Request $request)
    {
        $user = User::find($request['id']);
        $user->user_type = $request['kategorija'];
        $user->save();
        return redirect()->route('viewUsers');
    }

    public function blockUser(Request $request)
    {
        $user = User::find($request['id']);
        $user->user_type = User::ROLE_BANNED;
        $user->save();
        return redirect()->route('viewUsers');
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request['id']);
        $user->delete();
        return redirect()->route('viewUsers');
    }
}
