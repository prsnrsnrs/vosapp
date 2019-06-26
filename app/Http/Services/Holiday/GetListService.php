<?php

namespace App\Http\Services\Holiday;

use App\Http\Services\BaseService;
use App\Queries\HolidayQuery;
use Mockery\Exception;

/**
 * 祝日データ取得処理
 * @package App\Http\Services\Holiday
 */
class GetListService extends BaseService
{
    /**
     * サービスの処理を実行します。
     */
    public function execute()
    {
        $query = new HolidayQuery();
        $results = $query->getAll();
        if (!$results) {
            throw new Exception();
        }

        $holidays = [];
        foreach ($results as $row) {
            $year = substr($row['holiday_date'], 0, 4);
            $holidays[$year][] = $row;
        }
        $this->response_data['holidays'] = $holidays;
    }
}