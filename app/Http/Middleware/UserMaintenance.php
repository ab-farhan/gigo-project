<?php

namespace App\Http\Middleware;

use App\Models\User\BasicSetting;
use Closure;
use Auth;
use Illuminate\Support\Facades\Request;

class UserMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = getUser();
        $maintenanceStatus = $user->basic_setting->maintenance_status;
        $token = $user->basic_setting->bypass_token;

        if ($maintenanceStatus == 1) {
            if (session()->has('user-bypass-token') && session()->get('user-bypass-token') == $token) {
                return $next($request);
            }
            $userBs = BasicSetting::where('user_id', $user->id)->first();
            $data['userBs'] = $userBs;
            return response()->view('errors.user-503', $data);
        }

        return $next($request);
    }
}
