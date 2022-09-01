<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends BaseController
{

    public function register(Request $request)
    {

        $validator=Validator::make($request->all(),
            [
                    'name'=>'required',
            'email'=>'email|required',
            'password'=>'required',
            'c_password'=>'required|same:password'
            ]);

        if($validator->fails())
        {
            return $this->sendError('validation error: ',$validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
        


    }

    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('validation error: ',$validator->errors());
        }

        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
        {
            $user=Auth::user();
            $success['token']=$user->createToken('MyApp')->plainTextToken;
            $success['name']=$user->name;
            return $this->sendResponse($success, 'User Logged in successfully.');
        }
        else
        {
            return $this->sendError('invalid user :',['error'=>'invalid user']);
        }
    }
    
}
