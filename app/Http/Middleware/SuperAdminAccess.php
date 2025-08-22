<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\SuspiciousLoginNotification;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route()->getName();

        // Handle Login
        if ($route === 'login') {
            return $this->handleLogin($request);
        }

        // Handle Register
        if ($route === 'register') {
            return $this->handleRegister($request);
        }

        // Protect authenticated routes
        if (Auth::check()) {
            return $this->handleAuthenticated($request, $next);
        }

        return $next($request);
    }

    

    // -------- Login Logic --------
    protected function handleLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $fingerprint = $request->header('X-Device-Fingerprint') ?? '';
        $ip = $request->ip();
        $agent = $request->userAgent();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        if (!$user->is_active) {
            $this->logSession($user->id, session()->getId(), 'blocked', $ip, $agent);
            return response()->json(['message' => 'Account is blocked.'], 403);
        }

        // First login → store fingerprint
        if (!$user->device_fingerprint) {
            $user->device_fingerprint = $fingerprint;
            $user->user_ip = $ip;
            $user->save();
        }

        // Fingerprint mismatch → block
        if ($user->device_fingerprint !== $fingerprint) {
            $this->logSession($user->id, session()->getId(), 'kicked', $ip, $agent);
            return response()->json(['message' => 'Access denied: device mismatch.'], 403);
        }

        // Single session enforcement → kick old sessions
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '<>', session()->getId())
            ->where('event_type', 'success')
            ->update(['event_type' => 'kicked']);

        // Login user
        Auth::login($user);

        // Log current session
        $this->logSession($user->id, session()->getId(), 'success', $ip, $agent);

        return response()->json(['message' => 'Login successful.']);
    }

    // -------- Register Logic --------
    protected function handleRegister(Request $request)
    {
        $data = $request->only('name', 'email', 'password');
        $fingerprint = $request->header('X-Device-Fingerprint') ?? '';
        $ip = $request->ip();
        $agent = $request->userAgent();

        // Prevent duplicate email
        if (User::where('email', $data['email'])->exists()) {
            return response()->json(['message' => 'Email already registered.'], 409);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'device_fingerprint' => $fingerprint,
            'user_ip' => $ip,
            'is_active' => true
        ]);

        Auth::login($user);

        $this->logSession($user->id, session()->getId(), 'success', $ip, $agent);

        return response()->json(['message' => 'Registration successful.']);
    }

    // -------- Authenticated User Logic --------
    protected function handleAuthenticated(Request $request, Closure $next)
    {
        $user = Auth::user();
        $fingerprint = $request->header('X-Device-Fingerprint') ?? '';
        $ip = $request->ip();
        $agent = $request->userAgent();

        if (!$user->is_active) {
            Auth::logout();
            $this->logSession($user->id, session()->getId(), 'blocked', $ip, $agent);
            return response()->json(['message' => 'Account is blocked.'], 403);
        }

        if ($user->device_fingerprint !== $fingerprint) {
            Auth::logout();
            $this->logSession($user->id, session()->getId(), 'kicked', $ip, $agent);
            return response()->json(['message' => 'Access denied: device mismatch.'], 403);
        }

        // Single session enforcement
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '<>', session()->getId())
            ->where('event_type', 'success')
            ->update(['event_type' => 'kicked']);

        // Update IP if changed
        if ($user->user_ip !== $ip) {
            $user->user_ip = $ip;
            $user->save();
        }

        // Log session success
        $this->logSession($user->id, session()->getId(), 'success', $ip, $agent);

        return $next($request);
    }


    // -------- Session Logging Helper --------
    protected function logSession($userId, $sessionId, $event, $ip, $agent)
    {
        DB::table('sessions')->updateOrInsert(
            ['id' => $sessionId],
            [
                'user_id'       => $userId,
                'event_type'    => $event,
                'ip_address'    => $ip,
                'user_agent'    => $agent,
                'payload'       => json_encode([]),
                'last_activity' => time(),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
    }
}
