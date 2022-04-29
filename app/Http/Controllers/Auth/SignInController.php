<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SignInController extends Controller
{

        public function signinForm(){
            return view('auth.signin');
        }

    /**
     * Обработка попыток аутентификации.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        $credentials = Validator::make($request->all(),[
            'email'=>'required|email|exists:'.existByModel(User::class,'email'),
            'password'=>'required',
        ]);

        if (!$credentials->fails() && Auth::attempt($request->only(['email','password']))){

            return Redirect::route('home');
        }else{
            return Redirect::route('auth.signin-form')->withErrors($credentials)->withInput(
                $request->except('password')
            );
        }
    }

    public function signout()
    {
        session()->flush();
        return Redirect::route('auth.signin');
    }
}
