<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request){

        if ($request->isMethod('get')){
            return view('welcome');
        }
        $credentials = Validator::make($request->all(),[
            'email'=>'required|email|exists:'.existByModel(User::class,'email'),
        ]);

        if (!$credentials->fails()){
            Password::sendResetLink(
                $request->only('email')
            );
        }else{
            return response($credentials->errors(),422);
        }


    }

    public function confirmResetPassword(Request $request){
            if ($request->isMethod('get')){
                return view('auth.new_password')->with(['token'=>$request->token]);
            }else{
                $credentials = Validator::make($request->all(),[
                    'email'=>'required|email|exists:'.existByModel(User::class,'email'),
                    'password'=>'required|confirmed',
                ]);

                if (!$credentials->fails()){
                    $status = Password::reset(
                        $request->only('email', 'password', 'password_confirmation', 'token'),
                        function ($user, $password) {
                            $user->forceFill([
                                'password' => Hash::make($password)
                            ])->setRememberToken(Str::random(60));

                            $user->save();
                        }
                    );
                    if ($status){
                        return redirect(\route('auth.signin-form'));
                    }
                }else{
                    return response($credentials->errors(),422);
                }


            }
    }
}
