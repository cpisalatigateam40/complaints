<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearComplaintFilters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Hanya reset kalau bukan request ke complaint index/list/show/filter
        if (
            ! $request->is('complaints') &&
            ! $request->is('complaints/*')
        ) {
            session()->forget([
                'filter_month',
                'filter_year',
                'filter_departmentplant',
                'filter_status',
                'filter_sort',
                'filter_direction',
            ]);
        }

        return $next($request);
    }
}
