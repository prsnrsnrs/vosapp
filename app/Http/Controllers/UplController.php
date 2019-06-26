<?php

namespace App\Http\Controllers;

/**
 * アップロードサーバー系のコントローラです。
 * Class UplController
 * @package App\Http\Controllers
 */
class UplController extends BaseController
{
    /**
     * ファイルのアップロード
     */
    public function postUpload()
    {
        $disk = request('disk');
        $save_path = request('save_path');
        $file = request()->file('upload_file');
        $save_file_name = request('save_file_name');
        $ret = \Storage::disk($disk)->putFileAs($save_path, $file, $save_file_name);
        \Log::debug('upload', ['ret' => $ret, 'request' => request()->all()]);
        return response('', 200);
    }

    /**
     * ファイルのコピー
     */
    public function postCopy()
    {
        $disk = request('disk');
        $from_path = request('from_path');
        $to_path = request('to_path');
        $ret = \Storage::disk($disk)->copy($from_path, $to_path);
        \Log::debug('copy', ['ret' => $ret, 'request' => request()->all()]);
        return response('', 200);
    }

    /**
     * ファイルのダウンロード
     */
    public function getDownload()
    {
        $disk = request('disk');
        $path = request('path');
        \Log::debug('download', request()->all());
        return \Storage::disk($disk)->download($path);
    }

    /**
     * ファイルの削除
     */
    public function postDelete()
    {
        $disk = request('disk');
        $path = request('path');
        $ret = \Storage::disk($disk)->delete($path);
        \Log::debug('delete', ['ret' => $ret, 'request' => request()->all()]);
        return response('', 200);
    }
}