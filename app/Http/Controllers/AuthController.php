<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens;

    public function register(Request $request)
    {
        // validate the data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email', // unique:users,email means that the email field in the users table must be unique
            'password' => 'required|min:10|confirmed', // confirmed means that the password field must have a matching password_confirmation field
        ]);

        // store the data
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email; // email is unique
        $user->password = Hash::make($request->password); // Hash the password before saving it to the database
        $user->role = 'customer';
        $user->save();

        // skills table (transaction insert)
        $skills = $request->skills;
        $user->skills()->attach($skills);
        $token = $user->createToken('api-token')->plainTextToken;


        return response()->json([
            'message' => 'User created successfully',
            'user' => $user, 'token' => $token
        ]);
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }



    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'User logged out successfully']);
    }


    public function login_dev(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password) || $user->role !== "developer") {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;
        // store the token in session 
        config(['SCRIBE_AUTH_KEY' => $token]);

        return redirect()->route('docs');
    }



    public function restorePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided email is incorrect.'],
            ]);
        }


        return response()->json(['message' => 'Password reset link sent to your email']);
    }
}
