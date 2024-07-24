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
        

        //このミドルウェアを摘要したページはセッションに'viewed'があれば、特定のページを表示する
        if ($request->session()->has('viewed')) {
            return response()->view('user.onetime');
            
        }else{
            //このミドルウェアを摘要したページはキャッシュしない（戻るボタンで戻って表示されない）javascriptのhistory.replaceState({}, document.title, "/");の方が簡単か
            return $next($request)->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');;
        }
        
    }
}
