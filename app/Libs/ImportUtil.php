<?php

namespace App\Libs;

use Excel;
use Maatwebsite\Excel\Collections\RowCollection;

/**
 * Class ImportUtil
 * @package App\Libs
 */
class ImportUtil
{
    const DEFAULT_HEADER_ROW_NUMBER = 1;
    const DEFAULT_DATA_ROW_NUMBER = 2;

    /**
     * Excel or CSV ファイルを読込んだ結果のオブジェクトを返します。
     * @param string $file_path
     * @param string|int $header_row_number
     * @param string|int $data_row_number
     * @return RowCollection
     */
    public static function readUploadFile($file_path, $header_row_number = null, $data_row_number = null)
    {
        config(['excel.import.heading' => 'original']);
        $header_row_number = is_null($header_row_number) ? self::DEFAULT_HEADER_ROW_NUMBER : (int)$header_row_number;
        $data_row_number = is_null($data_row_number) ? self::DEFAULT_DATA_ROW_NUMBER : (int)$data_row_number;
        config(['excel.import.startRow' => $header_row_number]);
        $skip_number = self::calcSkipNumber($header_row_number, $data_row_number);
        try {
            $result = Excel::selectSheetsByIndex(0)->load($file_path, 'sjis')->skip($skip_number)->get();
        } catch (\ErrorException $e) {
            $result = Excel::selectSheetsByIndex(0)->load($file_path)->skip($skip_number)->get();
        }
        return $result;
    }

    /**
     * Excel or CSV 指定ファイルから見出し行データを返します。
     * @param string $file_path
     * @param string|int $header_row_number
     * @return array
     */
    public static function readHeading($file_path, $header_row_number = null)
    {
        config(['excel.import.heading' => 'original']);
        $header_row_number = is_null($header_row_number) ? self::DEFAULT_HEADER_ROW_NUMBER : (int)$header_row_number;
        config(['excel.import.startRow' => $header_row_number]);
        try {
            $result = Excel::selectSheetsByIndex(0)->load($file_path, function ($reader) {
                $reader->takeRows(1);
            }, 'sjis')->get()->getHeading();
        } catch (\ErrorException $e) {
            $result = Excel::selectSheetsByIndex(0)->load($file_path, function ($reader) {
                $reader->takeRows(1);
            })->get()->getHeading();
        }
        return $result;
    }

    /**
     * Excel or CSV ファイル文字列から見出し行データを返します。
     * @param string $file_path
     * @param string|int $header_row_number
     * @return array
     */
    public static function readHeadingForFileContents($file_contents, $header_row_number = null)
    {
        // ファイル文字列を一時ファイルに保存後、読み込みを実行する。
        $fp = tmpfile();
        fwrite($fp, $file_contents);
        fflush($fp);
        $fmeta = stream_get_meta_data($fp);
        $file_path = $fmeta['uri'];

        return self::readHeading($file_path, $header_row_number);
    }

    /**
     * Excel or CSV 指定ファイルからデータ行のデータを返します。
     * @param string $file_path
     * @param string|int $header_row_number
     * @param string|int $data_row_number
     * @return array
     */
    public static function readDataRows($file_path, $header_row_number = null, $data_row_number = null)
    {
        $data = self::readUploadFile($file_path, $header_row_number, $data_row_number);
        return array_map('array_values', $data->toArray());
    }

    /**
     * Excel or CSV ファイル文字列からデータ行のデータを返します。
     * @param string $file_contents
     * @param string|int $header_row_number
     * @param string|int $data_row_number
     * @return array
     */
    public static function readDataRowsForFileContents(
        $file_contents,
        $header_row_number = null,
        $data_row_number = null
    ) {
        // ファイル文字列を一時ファイルに保存後、読み込みを実行する。
        $fp = tmpfile();
        fwrite($fp, $file_contents);
        fflush($fp);
        $fmeta = stream_get_meta_data($fp);
        $file_path = $fmeta['uri'];

        return self::readDataRows($file_path, $header_row_number, $data_row_number);
    }

    /**
     * データ行がヘッダー行から見て何行先にデータがあるか抽出
     * @param int $header_row_number
     * @param int $data_row_number
     * @return int
     */
    private static function calcSkipNumber(int $header_row_number, int $data_row_number)
    {
        return $data_row_number - $header_row_number - 1;
    }
}