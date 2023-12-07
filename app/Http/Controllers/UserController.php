<?php

namespace App\Http\Controllers;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\models\User;

class UserController extends Controller
{
    function register(Request $req){
        $user = User::where('email', $req->input('email'))->first();

        if (!$user) {
            $validate = Validator::make(
                $req->all(),
                ['email' => 'required|email']
            );

            if ($validate->fails()) {
                return ["error", "Email is not valid"];
            } else {
                $validator = Validator::make(
                    $req->all(),
                    ['password' => 'required|min:8']
                );

                if ($validator->fails()) {
                    return ["error", "Password is too short, minimum 8 characters required"];
                } else {
                    $user = new User;
                    $user->name = $req->input('name');
                    $user->email = $req->input('email');
                    $user->password = Hash::make($req->input('password'));
                    $user->email_verification_token = Str::random(60);
                    $user->save();
                    $verificationUrl = route('email.verification', ['token' => $user->email_verification_token]);
                    Mail::to($user->email)->send(new VerificationEmail($user, $verificationUrl));
                    return $user;
                }
            }
        } else {
            return ["error", "Email already exists"];
        }
    }

    public function verifyEmail($token)
{
    $user = User::where('email_verification_token', $token)->first();

    if (!$user) {
        return 'Invalid token';
    }

    $user->email_verified_at = now();
    $user->email_verification_token = null;
    $user->save();

    return 'Email verified successfully';
}

public function login(Request $req)
{
    $credentials = $req->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $user->api_token = $token;
        $user->save();

        if ($user->email_verified_at === null) {
            return ["error" => "Email has not been verified."];
        }

        return response()->json(['token' => $token]);
    } else {
        return ["error" => "Email or password is not matched"];
    }
}


public function logout(Request $request)
{
    $user = Auth::guard('api')->user();

    if ($user) {
        $user->api_token = null;
        $user->save();

        return response()->json(['message' => 'Logged out successfully']);
    } else {
        return response()->json(['message' => 'No user is currently logged in.'], 401);
    }
}

}
