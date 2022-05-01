<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    public function registration(Request $request){

        if ($request->isMethod('get')){
            return view('auth.signup');
        }

        $credentials = Validator::make($request->all(),[
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
        ]);

        if (!$credentials->fails()){
           $user =  User::create([
               'name'=>$request->name,
               'email'=>$request->email,
               'password'=>Hash::make($request->password),
           ]);
            \Auth::login($user);
            return Redirect::route('home');
        }else{
            $errors = $credentials->errors();
            return Redirect::route('auth.signup-form')->withErrors($errors)->withInput(
                $request->except(['password','password_confirmation'])
            );
        }

    }
}
