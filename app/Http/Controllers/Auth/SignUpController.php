<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    public function registration(Request $request){

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
        }else{
            return response($credentials->errors(),422);
        }

    }
}
