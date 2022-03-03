<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\BlockedFromApi;

class LimitRequests {
    public function handle(Request $request, Closure $next) {
        // If env is testing then skipp middleware
        if (env('APP_ENV') === 'testing') 
            return $next($request);

        $userIp = $request->ip();
        $nowStamp = time();
        $stampBeforeOneHour = $nowStamp - 3600;

        // Fetch all the user logs where the ip is the users ip and the time stamp
        // is between now and the last one hour.
        $latestLog = \App\Models\LimitRequests::whereRaw(
            "ip = ? AND created_at > ?",
            [$userIp, $stampBeforeOneHour]
        )->get();

        if($latestLog->count() > 10)
            throw new BlockedFromApi();
        
        // Log the new movement and continue forth.
        $limitRequests = new \App\Models\LimitRequests;
        $limitRequests->ip = $userIp;
        $limitRequests->save();

        return $next($request);
    }
}
