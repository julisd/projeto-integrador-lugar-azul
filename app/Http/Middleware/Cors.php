<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Response;

class Cors
{
    public function handle($request, Closure $next)
    {
        if ($request->getMethod() == 'OPTIONS') {
            header('Access-Control-Allow-Origin: *');

            // ALLOW OPTIONS METHOD
            $headers = [
                'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'=> "Accept, Authorization, Content-Type",
            ];

            return Response::make('OK', 200, $headers);
        }

        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', "Accept, Authorization, Content-Type");


        return $response;
    }
}