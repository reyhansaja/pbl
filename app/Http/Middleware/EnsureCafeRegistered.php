<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCafeRegistered
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isOwner() && !auth()->user()->cafe) {
            if (!$request->routeIs('owner.cafe.create') && !$request->routeIs('owner.cafe.store')) {
                return redirect()->route('owner.cafe.create')
                    ->with('info', 'Please register your cafe first.');
            }
        }

        return $next($request);
    }
}
