<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
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

        if(!Auth::check()){
            return $next($request);
        }

        $user = Auth::user();
        $fingerprint = $request->header('X-Device-Fingerprint') ?? '';
        $ip = $request->ip();
        $agent = $request->userAgent();
        $sessionId = session()->getId();

        // Block if user is inactive
        if ($user->is_active == 0) {
            $this->logSession($user->id, $sessionId, 'blocked', $ip, $agent);
            Auth::logout();
            return response()->json(['message' => 'Your account is blocked.'], 403);
        }

        // First login → store fingerprint + IP
        if (!$user->device_fingerprint) {
            $user->device_fingerprint = $fingerprint;
            $user->user_ip = $ip;
            $user->save();
        }

        // Fingerprint mismatch → block
        if ($user->device_fingerprint !== $fingerprint) {
            $this->logSession($user->id, $sessionId, 'kicked', $ip, $agent);
            Auth::logout();
            return response()->json(['message' => 'Access denied: device mismatch.'], 403);
        }

        // Single session enforcement
        DB::table('sessions')->where('user_id', $user->id)->where('id', '<>', $sessionId)->where('event_type', 'success')->update(['event_type' => 'kicked']); // old sessions are kicked

        // Update IP if changed
        if ($user->user_ip !== $ip) {
            $user->user_ip = $ip;
            $user->save();
        }

        // Log current session as success
        $this->logSession($user->id, $sessionId, 'success', $ip, $agent);
        return $next($request);
    }

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
