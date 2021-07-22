<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Cache;
use Carbon\Carbon;

class LastSeenUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $expireTime = Carbon::now()->addMinute(1); // keep online for 1 min
            Cache::put('Attendance_online'.Auth::user()->id, Carbon::now(), $expireTime);
            //latest url visit
            $expireTime = Carbon::now()->addHour(12); // keep online for 1 min
            Cache::forever('latest_url_'.Auth::user()->id,  request()->getHost());
            Cache::forever('Attendance_latest_online_'.Auth::user()->id, Carbon::now());


            //Last Seen
            User::where('id', Auth::user()->id)->update(['last_seen' => Carbon::now()]);
        }
        return $next($request);
    }
}
