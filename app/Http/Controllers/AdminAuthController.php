<?php

namespace App\Http\Controllers;

use App\Http\Traits\AuthenticatesAdmins;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    use AuthenticatesAdmins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
}
