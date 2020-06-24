<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function changePassword(){
        return view('changepass');
    }

    public function updatePassword(Request $request){
        $this->validate(($request),[
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $pass = Hash::make($request->password);
        auth()->user()->update(['password'=>$pass]);

        return redirect()->route('changepass')->with('msg','Password Successfully Changed!');


    }
}
