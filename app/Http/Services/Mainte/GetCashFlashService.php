<?php

namespace App\Http\Services\Mainte;

use App\Exceptions\VossException;
use App\Http\Services\BaseService;

/**
 * APサーバ、WEBサーバのキャッシュを削除するサービスです
 * Class GetCashFlashService
 * @package App\Http\Services\Aps
 */
class GetCashFlashService extends BaseService
{

    const APP_ENV_APS = 'aps';

    const APP_IP_WEB1 = 'http://vossweb1';

    const APP_IP_WEB2 = 'http://vossweb2';

    const APP_IP_VOSSDEV = 'http://localhost';

    const REQUEST_PATH = '/non_public/cash_flush';


    /**
     * サービスの処理を実行します
     * @return mixed|void
     * @throws VossException
     */
    public function execute()
    {

        $server_name = config('app.env');

        if ($server_name === self::APP_ENV_APS) {
            $this->cashRequest(self::APP_IP_WEB1);
            $this->cashRequest(self::APP_IP_WEB2);

        } else {
            $this->cashRequest(self::APP_IP_VOSSDEV);

        }
    }

    /**
     * 各WEBサーバーにリクエストを投げ、
     * キャッシュクリア処理を行います
     * @param $base_url
     * @throws VossException
     */
    public function cashRequest($base_url)
    {

        $client = new \GuzzleHttp\Client(['base_uri' => $base_url]);
        $response = $client->request('GET', self::REQUEST_PATH, ['allow_redirects' => true,]);
        $response_body = $response->getBody();

        if (!$response_body) {
            throw new VossException('キャッシュクリア失敗');
        }
    }
}