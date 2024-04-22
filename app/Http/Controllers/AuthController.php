<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use App\Mail\OtpMail;

use App\Jobs\SendEmilJob;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{


    public function loginPage(){
        return view('auth/login');
    }


    public function registerPage(){
        return 'login registerPage';
    }

    public function forgotPasswordLode(){
        return view('auth.forgot-password');
    }


    public function sendOtp(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Extract email from the request
        $email = $request->email;

        // Check if the user exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Generate OTP
        $otp = random_int(100000, 999999);

        // Store OTP in user record
        $user->otp = $otp;
        $user->save();

        // Dispatch the job to send OTP
        dispatch(new SendEmilJob($email, $otp));

        return response()->json(['message' => 'OTP sent successfully'], 200);
    }


    public function otpSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6|exists:users,otp',
        ], [
            'otp.digits' => 'The OTP should be exactly six digits.',
            'otp.exists' => 'The OTP you entered is incorrect.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::where('otp', $request->otp)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->otp = null;
            $user->save();
            return response()->json(['message' => 'OTP Verification Successful'], 200);
        }

        return response()->json(['message' => 'Invalid OTP'], 422);
    }




    public function resetPasswordLode(Request $request){
        $data = [];
        $data['token'] = $request->token;
        $data['email'] = $request->email;
        return view('auth.reset-password',$data);
    }




    public function login(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            // Authentication was successful, retrieve the authenticated user
            $user = Auth::user();
            $token = $user->createToken('myToken')->plainTextToken;
            $user->tokens()->where('name', 'myToken')->latest()->first()->update(['expires_at' => now()->addMinutes(10)]);

            // Return the user and the token
            return response()->json([
                'user' => $user,
                'token' => $token,
                'role' => Role::findOrFail($user->role),
            ], 200);
        }

        // Authentication failed
        // Check if email is incorrect
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['error' => 'Email is incorrect'], 401);
        }

        // Email is correct but password is incorrect
        return response()->json(['error' => 'Password is incorrect'], 401);
    }
    public function logout(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Revoke all of the user's tokens
        $user->tokens()->delete();

        // Return a success response
        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
    public function check(){
        $user = Auth::user();
        // Now you can use $user to access the authenticated user's information
        return response()->json(['user' => $user]);

    }

    public function register(Request $request){
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string', // Bangla name validation rule
            'enname' => 'required|string', // English name validation rule
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'cell' => 'required|string|regex:/^[0-9]{10,15}$/',
        ]);

        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->enname = $request->enname;
        $user->email = $request->email;
        $user->role = 10;
//        If a user registers from outside then his emailid is username || inside  username = will be given from the application
        $user->username = $request->email;
        $user->password = Hash::make($request->password);
        $user->cell = $request->cell;
        $user->save();

        // Generate token for the user (assuming you are using Laravel Passport for API authentication)
        $token = $user->createToken('myToken')->plainTextToken;

        // Return the user and the token
        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => Role::findOrFail($user->role),
        ], 201); // 201 Created status code
    }



    public function forgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
          $request->only('email')
      );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email'], 200)
            : response()->json(['error' => 'Unable to send reset link'], 500);
    }


    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully'], 200)
            : response()->json(['error' => 'Unable to reset password'], 500);
    }






}
