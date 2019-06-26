<?php

namespace App\Http\Services\Reservation\Input;

use App\Http\Services\BaseService;
use App\Libs\Voss\VossAccessManager;
use App\Queries\ReservationQuery;
use Illuminate\Support\Collection;


/**
 * 質問事項のサービスクラスです。
 * Class GetQuestionService
 * @package App\Http\Services\Reservation\Input
 */
class GetQuestionService extends BaseService
{
    /**
     * @var string
     */
    private $reservation_number;
    /**
     * @var ReservationQuery
     */
    private $reservation_query;

    /**
     * サービスクラスを初期化します。
     */
    protected function init()
    {
        $this->reservation_number = request('reservation_number');
        $this->reservation_query = new ReservationQuery();
    }

    /**
     * サービスの処理を実行します。
     * @return mixed|void
     */
    public function execute()
    {
        //予約見出し情報の取得
        $item_info = $this->reservation_query->getReservationByNumber($this->reservation_number);
        $this->response_data['item_info'] = $item_info;

        //質問項目の取得
        $questions = $this->reservation_query->getQuestions();
        $format_questions = $this->formatQuestions($questions);
        $this->response_data['questions'] = $format_questions;
        //表示される質問数取得
        $questions_count = count($format_questions);
        $this->response_data['questions_count'] = $questions_count;

        //質問入力情報の取得
        $passengers = $this->reservation_query->getQuestionAnswer($this->reservation_number);
        $format_passengers = $this->formatPassengers($passengers);
        $this->response_data['passengers'] = $format_passengers;
    }

    /**
     * 質問入力情報の取得クエリで取得したデータを乗船者行Noでグループ化し、1から連番の配列を返します。
     * @param $passengers
     * @return array
     */
    private function formatPassengers($passengers)
    {
        $collection = new Collection($passengers);
        $passengers = $collection->groupBy('passenger_line_number')->toArray();
        $passengers = array_merge($passengers);
        $key = [];
        for ($i=1; $i<=count($passengers); $i++){
            $key[$i] = $i;
        }
        $passengers = array_combine($key,$passengers);
        return $passengers;
    }

    /**
     * 質問項目の取得クエリで取得したデータを成形します。
     * @param $questions
     * @return array
     */
    private function formatQuestions($questions)
    {
        //個人向け以外の画面で、個人のみが"Y"のデータは旅行者用では表示しないので省く
        if (!VossAccessManager::isUserSite()) {
            foreach ($questions as $key => $question) {
                if ($question['delited_flag'] === 'Y') {
                    unset($questions[$key]);
                }
            }
            $questions = array_values($questions);
        }
        //キーを質問コードに変換します。
        $questions = array_column($questions, null, 'question_code');
        return $questions;
    }
}