<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'age' => 'required',
            'role_id' => 'required'
        ]);

        $user = User::create([
           'name' => $request->name,

            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'age'    => $request->age,
            'role_id'    => $request->role_id,
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['message' => 'Login successful']);
    }
    public function show()
{
    return response()->json([
        'message' => 'Welcome to the register endpoint',
        'example_request' => [
            'name' => 'Mohammad Khatib',
            'email' => 'mohammad@example.com',
            'password' => 'secret123',
             'age' => '20',
            'role_id' => 1
        ]
    ]);
}

}
