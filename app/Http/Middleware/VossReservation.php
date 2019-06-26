<?php

namespace App\Http\Middleware;

use App\Queries\ReservationQuery;
use Closure;
use Illuminate\Http\Request;

/**
 * 予約番号のアクセスチェック
 * Class VossReservation
 * @package App\Http\Middleware
 */
class VossReservation
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $query = new ReservationQuery();
        if (!$query->getAccessibleReservationNumber($request->get('reservation_number'))) {
            return abort(404);
        }
        return $next($request);
    }
}