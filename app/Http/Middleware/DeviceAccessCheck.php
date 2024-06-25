<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeviceAccessCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // $deviceId = $request->header('Device-ID'); // フロントエンドから送信されたデバイスID

        // if ($deviceId) {
        //     $deviceAccess = DeviceAccess::where('device_id', $deviceId)->first();

        //     if ($deviceAccess) {
        //         return response()->json(['message' => 'This device has already accessed.'], 403);
        //     } else {
        //         DeviceAccess::create(['device_id' => $deviceId]);
        //     }
        // } else {
        //     return response()->json(['message' => 'Device ID is required.'], 400);
        // }
        // dd($request->session());
        
        if ($request->session()->has('viewed')) {
            return response()->view('user.onetime');
            // return response('This page has already been viewed',403);
        }
        
       

        return $next($request);
    }
}
