<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * This is ignored if you define the `authenticated` method.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle post-login redirection based on user role.
     */
    protected function authenticated(Request $request, $user)
    {
        // Assuming is_admin: 1 = admin, 2 = cashier
        if ($user->is_admin == 1) {
            return redirect('/home'); // Admin dashboard
        } elseif ($user->is_admin == 2) {
            return redirect()->route('counter_sales.index'); // Cashier dashboard (OrderController)
        }

        // Default redirect if no role matches
        return redirect('/home');
    }


    
}
