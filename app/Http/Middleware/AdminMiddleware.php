<?php
   
namespace App\Http\Middleware;
   
use Closure;
use App;
   
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        
        // Check if user is admin

        if ($request->user() && $request->user()->type == 1) { 
            return $next($request);

        } else {
            $response = [
                'success' => false,
                'message' => "You are not allowed to this section!",
            ];
        } 
        return $next($request);
    }
}