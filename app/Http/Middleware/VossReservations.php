<?php

namespace App\Http\Middleware;

use App\Queries\ReservationQuery;
use Closure;
use Illuminate\Http\Request;

/**
 * 複数の予約番号のアクセスチェック
 * Class VossReservations
 * @package App\Http\Middleware
 */
class VossReservations
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
        $reservations = $request->get('reservations');
        foreach ($reservations as $reservation_number => $passenger_line_numbers) {
            if (!$query->getAccessibleReservationNumber($reservation_number)) {
                return abort(404);
            }
        }
        return $next($request);
    }
}