<?php

namespace App\Libs\Voss;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * VOSS専用 UPLサーバーに通信を行うクラスです。
 *
 * Class VossUplClient
 * @package App\Libs
 */
class VossUplClient
{

    /**
     * @param string $disk
     * @param $uploaded_file_path
     * @param string $save_path
     * @param string $save_file_name
     * @return bool
     */
    public static function upload($disk, $uploaded_file_path, $save_path, $save_file_name)
    {
        $client = new Client();
        $url = config('upl.url') . '/upl/upload';
        try {
            $response = $client->request('POST', $url, [
                'multipart' => [
                    [
                        'name' => 'upload_file',
                        'contents' => fopen($uploaded_file_path, 'r')
                    ],
                    [
                        'name' => 'disk',
                        'contents' => $disk,
                    ],
                    [
                        'name' => 'save_path',
                        'contents' => $save_path,
                    ],
                    [
                        'name' => 'save_file_name',
                        'contents' => $save_file_name,
                    ],
                ]
            ]);
            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            \Log::error($e->getMessage(), $e->getTrace());
            return false;
        }
    }

    /**
     * @param $disk
     * @param $from_path
     * @param $to_path
     * @return bool
     */
    public static function copy($disk, $from_path, $to_path)
    {
        $client = new Client();
        $url = config('upl.url') . '/upl/copy';
        try {
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'disk' => $disk,
                    'from_path' => $from_path,
                    'to_path' => $to_path,
                ]
            ]);
            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            \Log::error($e->getMessage(), $e->getTrace());
            return false;
        }
    }

    /**
     * @param $disk
     * @param $path
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     */
    public static function download($disk, $path)
    {
        $client = new Client();
        $url = config('upl.url') . '/upl/download';
        try {
            $response = $client->request('GET', $url, [
                'query' => [
                    'disk' => $disk,
                    'path' => $path
                ],
            ]);
            return $response;
        } catch (GuzzleException $e) {
            \Log::error($e->getMessage(), $e->getTrace());
            return false;
        }
    }

    /**
     * @param string $disk
     * @param string $path
     * @return bool
     */
    public static function delete($disk, $path)
    {
        $client = new Client();
        $url = config('upl.url') . '/upl/delete';
        try {
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'disk' => $disk,
                    'path' => $path
                ]
            ]);
            return $response->getStatusCode() === 200;
        } catch (GuzzleException $e) {
            \Log::error($e->getMessage(), $e->getTrace());
            return false;
        }
    }

}