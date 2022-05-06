<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function getUserInfo(){
       return response(User::find(\Auth::id()),200) ;
   }
    public function updateUserInfo(Request $request){
        $user = User::find(\Auth::id());
        $user->ow_city_id = $request->ow_city_id;
        return response('',$user->save()?200:400);
    }

}
