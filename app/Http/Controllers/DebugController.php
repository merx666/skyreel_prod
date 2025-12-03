<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugController extends Controller
{
    /**
     * Log a debug entry. Restricted to local environment or localhost requests.
     */
    public function log(Request $request)
    {
        $ip = $request->ip();
        $allowed = app()->isLocal() || $ip === '127.0.0.1' || $ip === '::1';
        if (!$allowed) {
            abort(403);
        }

        Log::info('Debug log hit', [
            'ip' => $ip,
            'user_id' => auth()->id(),
            'user_agent' => $request->userAgent(),
            'ts' => now()->toDateTimeString(),
        ]);

        return response()->json(['status' => 'ok']);
    }
}