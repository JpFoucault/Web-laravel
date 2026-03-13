<?php

namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmEmailController extends Controller
{
    Public function index(){
        return view('pages.login.confirm_email');
    }
}
