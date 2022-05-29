<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Models\Users\User;
use RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    public function register(Request $request){

        if($request->isMethod('post')){
            $data = $request->input();

            $validator =$this->validator($data);

            if ($validator->fails()) {
                return redirect('/register')
                ->withErrors($validator)
                ->withInput();
            }

            $this->create($data);

            return redirect('added');
        }

        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|min:2|max:12',
            'email' => 'required|string|email|min:5|max:40|unique:users',
            'password' => 'required|string|min:8|max:20|confirmed',
            'password_confirmation' => 'required|string|min:8|max: 20',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function added(){
        return view('auth.added');
    }
}
