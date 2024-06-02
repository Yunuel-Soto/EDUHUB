<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewsController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        return view('users/home');
    }

    public function showSing()
    {
        return view('users/singIn');
    }

    public function showLogin()
    {
        return view('users/login');
    }

    public function createUser()
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        return view('admin/createUser');
    }

    public function catalogos()
    {
        $user = Auth::user();

        if(!$user) {
            return redirect()->route('shLogin');
        }

        if(!$user->getRoles('ROLE_SUPERADMIN') or !$user->getRoles('ROLE_ADMIN')) {
            return redirect()->route('home');
        }

        return view('catalogos/index');
    }
}