<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{


    public function admin_login()
    {
        return view('auth.login');
    }



    public function index()
    {
        return view('backend.dashboard');
    }


}
