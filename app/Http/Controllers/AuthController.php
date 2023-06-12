<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;


class AuthController extends Controller
{
    public function login() {

        return view('auth.login');

    }

    public function register() {

            return view('auth.register');

    }

    public function dashboard() {

            return view('dashboard');


    }




    public function validateform(Request $req)
    {
        $validator = Validator::make($req->all(),[

          'email' => 'required|email',
          'password' => ['required',]

        ]);

        if($validator->passes())
        {
            $user = DB::table('users')->where('email',$req->email)->where('password',$req->password)->value('email','password');

            if($user)
            {
                $hello = DB::table('users')->where('email',$req->email)->where('password',$req->password)->value('first_name');
                $hello1 = DB::table('users')->where('email',$req->email)->where('password',$req->password)->value('id');
                Session::put('user',$hello);
                Session::put('id',$hello1);
                return response()->json(['success'=>'New Account Created Succesfully']);
            }
            return response()->json(['failed'=>'Oops it seems like you dont have account or invalid username or password']);

        }
        return response()->json(['error'=>$validator->errors()]);

    }

    public function validateform_register(Request $req)
    {

    $validator = Validator::make($req->all(), [
        'first_name' => 'required',
        'last_name' => 'required',
        'register_email' => 'required|email',
        'register_password' => ['required', 'string', Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
        'c_password' => 'required|same:register_password'


    ]);
    if ($validator->passes())
    {
        DB::table('users')->insert([

            'first_name' => $req->first_name,
            'last_name' => $req->last_name,
            'email' => $req->register_email,
            'password' => $req->register_password
        ]);
        return response()->json(['success' => 'New Account Create Successfully']);
    }
        return response()->json(['error' => $validator->errors()]);
    }


    public function logout(Request $req){
        Session::forget('user');
        $req -> session()->invalidate();
        $req -> session()->regenerateToken();
        return redirect('/admin/login');

    }







}

