<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class AdminSystemController extends Controller
{
    public function login() 
    {
        return view('admin.auth.login');
    }
    
    public function index() 
    {
        return view('admin.index');
    }

}
