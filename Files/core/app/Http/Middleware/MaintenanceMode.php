<?php

namespace App\Http\Middleware;

use App\Models\GeneralSetting;
use Closure;

class MaintenanceMode
{
    public function handle($request, Closure $next)
    {
        $general = GeneralSetting::first();
        if ($general->maintenance_mode == 1) {

            if ($request->is('api/*')) {
                $notify[] = 'Our application is currently in maintenance mode';
                return response()->json([
                    'remark'=>'maintenance_mode',
                    'status'=>'error',
                    'message'=>['error'=>$notify]
                ]);
            }else{
                return redirect()->route('maintenance');
            }
        }
        return $next($request);
    }
}
