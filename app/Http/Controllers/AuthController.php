<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function requestToken(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $current_date_time = \Carbon\Carbon::now()->toDateTimeString();

        return response()->json([
          'token' => $user->createToken($current_date_time)->plainTextToken
        ]);
    }

    public function register(Request $request) {
      $request->validate([
        'email' => 'required|email:rfc,dns',
        'password' => 'required',
        'name' => 'required'
      ]);

      $user = User::Create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'name' => $request->name,
        ]);

      $current_date_time = \Carbon\Carbon::now()->toDateTimeString();

      return response()->json([
        'token' => $user->createToken($current_date_time)->plainTextToken
      ]);
    }


}
