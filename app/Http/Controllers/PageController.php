<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function helloAdmin()
    {
        return view('pages.hello-admin');
    }

    public function helloStaff()
    {
        return view('pages.hello-staff');
    }

    public function helloUser()
    {
        return view('pages.hello-user');
    }
}
