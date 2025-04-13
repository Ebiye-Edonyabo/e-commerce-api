<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\{Request, Response };
use Illuminate\Support\Facades\{Auth, Hash };
use App\Http\Requests\{RegisterRequest, UpdateInfoRequest, UpdatePasswordRequest};
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    
    public function register(RegisterRequest $request) 
    {
        // validate
        // store user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // return response
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if( ! Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response([
                'error' => 'Invalid credentials', Response::HTTP_UNAUTHORIZED
            ]);
        }
        $user = Auth::user();

        if( $user && $user->is_admin === 1){
            // create token for the user with specific scope
            $userToken =  $user->createToken('token', ['admin'] )->plainTextToken;
        }else{
            // create token for ambassador scope
            $userToken =  $user->createToken('token', ['ambassador'] )->plainTextToken;
            // return response()->json($userToken, 200); // when returning token directly
        }

        // store token in cookie 
        $tokenCookie = cookie('tokenCookie', $userToken, 60 * 24,);

        // return cookie: to enable the front-end to get the cookie, publish cors config and set support_credentials to true
        //   also included the cookie check on the authenticate middleware to auto check when accessing auth:sanctum routes
        return response()->json([
            'message' => 'success'
        ])->withCookie($tokenCookie);  

    }

    public function user(Request $request)
    {
        $user = $request->user();
        return new UserResource($user);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = $request->user();
        $user->update($request->only('name', 'email'));
        return response()->json($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);
        return response()->json($user, Response::HTTP_ACCEPTED);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();
        return response()->json(['message' => 'Delete', Response::HTTP_NO_CONTENT]);
    }

    public function logout()
    {
        // remove the cookie to logout
        return response()->json([
            'message' => 'success',
        ])->withoutCookie('tokenCookie');
    }
}
