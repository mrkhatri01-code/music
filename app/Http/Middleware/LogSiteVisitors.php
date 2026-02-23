<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogSiteVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't log admin pages, assets, or API calls to avoid noise
        if ($request->is('admin*') || $request->is('api*') || $request->is('_debugbar*')) {
            return $next($request);
        }

        // Don't log if it's a bot (optional, simple check)
        $userAgent = $request->header('User-Agent');
        // if (str_contains(strtolower($userAgent), 'bot')) { return $next($request); }

        try {
            \App\Models\VisitLog::create([
                'ip_address' => $request->ip(),
                'url' => $request->fullUrl(),
                'referral' => $request->header('referer'),
                'user_agent' => $userAgent,
                'user_id' => auth()->id(),
                'location_data' => null, // Will allow controller/job to resolve this later to avoid slowing down request
            ]);
        } catch (\Exception $e) {
            // changing nothing, just fail silently so user experience isn't affected
        }

        return $next($request);
    }
}
