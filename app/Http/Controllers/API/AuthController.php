<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return User::all();
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'required|in:School,Technician,RTB-Staff,Admin',
        'phone' => 'nullable|string|max:15',
        'gender' => 'nullable|string|in:Male,Female',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
       'password' => Hash::make($validated['password']),
        'phone' => $validated['phone'] ?? null,
        'gender' => $validated['gender'] ?? null,
    ]);

    // Ensure the role exists before assignment
    $role = Role::where('name', $validated['role'])->first();

    if (!$role) {
        return response()->json(['message' => 'Invalid role'], 400);
    }

    $user->assignRole($role->name);

    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user->load('roles'), // Include role info in response
    ]);
}
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    // Generate 6-digit OTP
    $otp = random_int(100000, 999999);

    // Save to user with expiry
    $user->otp_code = $otp;
    $user->otp_expires_at = Carbon::now()->addMinutes(10);
    $user->save();

    // Send email
    Mail::raw("Your OTP code is: $otp", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Your OTP Code');
    });

    return response()->json([
        'message' => 'OTP sent to your email',
        'user_id' => $user->id
    ]);
}
public function verifyOtp(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'otp_code' => 'required|digits:6'
    ]);

    $user = User::find($request->user_id);

    if (
        $user->otp_code !== $request->otp_code ||
        Carbon::parse($user->otp_expires_at)->lt(now())
    ) {
        return response()->json(['message' => 'Invalid or expired OTP'], 401);
    }

    // Clear OTP fields
    $user->otp_code = null;
    $user->otp_expires_at = null;
    $user->save();

    // Issue token
    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user->load('roles'),
    ]);
}
// logout logic
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out successfully']);

}
}