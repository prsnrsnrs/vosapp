<?php

namespace App\Http\Services\Reservation\Printing;

/**
 * 乗船券発行、各種印刷サービスの基底クラスです。
 * @package App\Http\Services\Printing
 */
abstract class BaseService extends \App\Http\Services\BaseService
{

    /**
     * JSONファイルを読み込み、デコードした配列を返します。
     * @param $file_path
     * @return array|mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function readJson($file_path)
    {
        $file_path = config('filesystems.disks.print_order.root') . DIRECTORY_SEPARATOR . $file_path;
        try {
            $json_data = file_get_contents($file_path);
        } catch (\Exception $e) {
            \Log::info('printorderにアクセス失敗。net useコマンドを実行');
            exec('net use ' . config('filesystems.disks.print_order.root') . ' /user:webvoss V3T0R1B0S5');
            $json_data = file_get_contents($file_path);
        }
        $json_string = mb_convert_encoding($json_data, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $json = json_decode($json_string, true);
        return $json;
    }
}