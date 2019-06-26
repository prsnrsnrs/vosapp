<?php

namespace App\Operations;


class AgentImportCompleteOperation extends BaseOperation
{
    /**
     * 初期化処理を実行します
     */
    protected function init()
    {
        $this->setCommonOperationCode('252');
    }

    /**
     * 一次インポート管理番号を定義します
     * @param $import_management_number
     * @throws \Exception
     */
    public function setImportManagementNumber($import_management_number)
    {
        $this->set(11, 43, $import_management_number, ['padding' => 0, 'right' => false]);
    }

    /**
     * 回答ソケットを定義します
     * @return array
     */
    public function parseResponse()
    {
        $response = [
//            'import_error_count' => trim($this->parse(4, 16,['padding' => 0, 'right' => false])),
            'import_count' => trim($this->parse(4, 16)),
        ];
        return $response;
    }
}