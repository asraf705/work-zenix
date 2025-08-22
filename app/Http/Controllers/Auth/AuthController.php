<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //---------Login-------------------
    public function loginFrom(){
        return view("auth.login");
    }

    // -------- REGISTER --------
    public function registerFrom(){
        return view("auth.register");
    }


    // -------- REGISTER --------
    public function register(Request $request)
    {

        dd($request->all());
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|number|accepted|unique:user',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $fingerprint = $request->header('X-Device-Fingerprint') ?? '';
        $ip = $request->ip();
        $agent = $request->userAgent();

        $user = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'password'           => bcrypt($request->password),
            'device_fingerprint' => $fingerprint,
            'user_ip'            => $ip,
            'is_active'          => 0,
        ]);

        Auth::login($user);

        $this->logSession($user->id, session()->getId(), 'success', $ip, $agent, $user->user_role);

        return response()->json(['message' => 'Registration successful.']);
    }

    // -------- LOGIN --------
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $fingerprint = $request->header('X-Device-Fingerprint') ?? '';
        $ip = $request->ip();
        $agent = $request->userAgent();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        if (!$user->is_active) {
            $this->logSession($user->id, session()->getId(), 'blocked', $ip, $agent, $user->user_role);
            return response()->json(['message' => 'Account is blocked.'], 403);
        }

        // First login → store fingerprint + IP
        if (!$user->device_fingerprint) {
            $user->device_fingerprint = $fingerprint;
            $user->user_ip = $ip;
            $user->save();
        }

        // Fingerprint mismatch → block
        if ($user->device_fingerprint !== $fingerprint) {
            $this->logSession($user->id, session()->getId(), 'kicked', $ip, $agent, $user->user_role);
            return response()->json(['message' => 'Access denied: device mismatch.'], 403);
        }

        // Single session enforcement → kick old sessions
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '<>', session()->getId())
            ->where('event_type', 'success')
            ->update(['event_type' => 'kicked']);

        Auth::login($user);

        $this->logSession($user->id, session()->getId(), 'success', $ip, $agent, $user->user_role);

        return response()->json(['message' => 'Login successful.']);
    }

    // -------- LOGOUT --------
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->logSession($user->id, session()->getId(), 'logout', $request->ip(), $request->userAgent(), $user->user_role);
            Auth::logout();
        }

        return response()->json(['message' => 'Logged out successfully.']);
    }

    // -------- SESSION LOGGING --------
    protected function logSession($userId, $sessionId, $event, $ip, $agent, $role)
    {
        DB::table('sessions')->updateOrInsert(
            ['id' => $sessionId],
            [
                'user_id'       => $userId,
                'event_type'    => $event,
                'ip_address'    => $ip,
                'user_agent'    => $agent,
                'payload'       => json_encode(['role' => $role]),
                'last_activity' => time(),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }


}
