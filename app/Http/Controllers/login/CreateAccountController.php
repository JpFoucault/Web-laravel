<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateAccountController extends Controller
{
    Public function index(){
        return view('pages.login.create_account');
    }
}
