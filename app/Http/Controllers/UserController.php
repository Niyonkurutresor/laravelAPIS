<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    //
    public function createUser(Request $request ){
        try{
        $valid = $request->validate(
        [
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email|max:255',
            'password'=>'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8'        ]
        );

        // create user
        $user = User::create($valid);
        return response()->json([
            'Message'=>'User created successfully!',
            'token'=>$user->createToken($request->email)->plainTextToken
        ],201);

        }catch(\Throwable $error){
            return response()->json(['Message'=>'INTERNAL SERVER ERROR!', 'error'=>$error->getMessage()]);
        }
    }


    public function login(Request $request){
        try{
            
            $validateLogin = $request->validate(
            [
                'email'=>'required|email',
            ]
            );

            // find user
            $user = User::where('email',$request->email)->first();
            if(empty($user)){
                return response()->json([
                        'message'=>'User Not found', ]);
             }
            if(!Hash::check($request->password,$user->password)){
               return response()->json([
                       'message'=>'Incollect userName or Password', ]);
            }
            // if(!Auth::attempt($request->only(['email','password']))){
            //     return response()->json(
            //         [
            //             'message'=>'Email & password does not mutch with our record',
            //         ],
            //         401
            //     );
            //     };

            
            return response()->json(
                [
                    'message'=>'Logged in successfully!',
                    'token'=>$user->createToken($request->email)->plainTextToken
                ]);
        }catch(\Throwable $error){
            return response()->json(['Message'=>'INTERNAL SERVER ERROR!', 'error'=>$error->getMessage()],500);
        }
    }

    public function logout(Request $request){
        $user = $request->user();
    if ($user) {
        $user->tokens()->delete(); 
        return response()->json(['message' => 'Logout successfully!']);
    }
    return response()->json(['message' => 'No authenticated user found.'], 401);
    }
}
