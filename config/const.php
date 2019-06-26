<?php

/**
 * 定数を定義します。
 */

return [
    // 旅行社ごとの定数
    'travel_company' => [
        'jtb' => [
            'code' => [
                'JTBTEST',
                'JTBVOSS',
                'JTB0012'
            ],
            'unique_format_number' => 3,
        ],
    ],
    // 検索初期条件
    'search_con' => [
        // クルーズプラン検索
        'cruise_plan_search' => [
            'item_code' => '',
            'departure_date_from' => '',
            'departure_date_to' => '',
            'departure_port_code' => '',
            'cruise_id' => '',
            'page' => '1',
        ],
        // 予約受付一覧
        'reservation_reception_list' => [
            'departure_date_from' => '',
            'departure_date_to' => '',
            'item_code' => '',
            'reservation_number' => '',
            'boss_name' => '',
            'status_hk' => '',
            'status_wt' => '',
            'status_cx' => '',
            'detail_input_flag_fin' => '',
            'detail_input_flag_yet' => '',
            'submit_document_flag_fin' => '',
            'submit_document_flag_yet' => '',
            'page' => '1',
        ],
        // 販売店一覧
        'agent_list' => [
            'agent_name' => '',
            'agent_jurisdiction' => '',
            'agent_general' => '',
            'page' => '1',
        ],
        // ご連絡一覧
        'reservation_contact_list' => [
            'status_need_answer' => '',
            'status_not_need_answer' => '',
            'status_information' => '',
            'departure_date_from' => '',
            'departure_date_to' => '',
            'item_code' => '',
            'reservation_number' => '',
            'boss_name' => '',
            'agent_type' => '',
            'page' => '1',
            'contact_sort' => 'contact_date_desc',
            'departure_sort' => '',
        ],
        // 乗船券控え・確認書の印刷
        'reservation_printing_list' => [
            'departure_date_from' => '',
            'departure_date_to' => '',
            'reservation_number' => '',
            'passenger_name' => '',
            'item_code' => ''
        ]
    ],
    // 戻る・パンくず
    'return_param' => [
        'route_name' => '',
        'reservation_number' => ''
    ],
    // ユーザー区分
    'user_type' => [
        'name' => [
            0 => '一般',
            1 => '管理者',
        ],
        'value' => [
            'general' => 0,
            'admin' => 1,
        ],
    ],
    // 販売店区分
    'agent_type' => [
        'name' => [
            0 => '一般店',
            1 => '管轄店',
        ],
        'value' => [
            'agent' => 0,
            'jurisdiction_agent' => 1,
        ],
    ],
    // 販売店管理 ログインタイプ
    'login_type' => [
        'name' => [
            0 => '無効',
            1 => '有効',
        ],
        'value' => [
            'disable' => 0,
            'enable' => 1,
        ],
    ],
    // 空席状況
    'vacancy' => [
        'name' => [
            0 => '-',
            1 => '〇',
            2 => '△',
            4 => '×',
            9 => '-',
        ],
        'value' => [
            'yet' => 0,
            'empty' => 1,
            'few' => 2,
            'full' => 4,
            'not' => 9,
        ]
    ],
    // 代表者区分
    'boss_type' => [
        'name' => [
            'Y' => '〇',
        ],
        'value' => [
            'boss' => 'Y',
        ]
    ],
    // 大小幼区分
    'age_type' => [
        'name' => [
            'A' => '大人',
            'C' => '小人',
            'I' => '幼児',
        ],
        'short_name' => [
            'A' => '大',
            'C' => '小',
            'I' => '幼',
        ],
        'full_name' => [
            'A' => '大人（中学生以上）',
            'C' => '２歳以上～小学生以下',
            'I' => '６カ月以上～２歳未満',
        ],
        'value' => [
            'adult' => 'A',
            'child' => 'C',
            'infant' => 'I',
        ],
    ],

    // 客室タイプ説明(単位)
    'description_default_style' => [
        'unit' => [
            'floor' => '階',
            'area' => '㎡',
        ]
    ],
    // 料金タイプ
    'fare_type' => [
        'name' => [
            'SG' => 'シングル',
            'TW' => 'ツイン',
            'TP' => 'トリプル',
        ],
        'value' => [
            'single' => 'SG',
            'twin' => 'TW',
            'triple' => 'TP',
        ]
    ],
    // 性別
    'gender' => [
        'name' => [
            'M' => '男',
            'F' => '女',
        ],
        'name_eij' => [
            'M' => 'Mr',
            'F' => 'Ms',
        ],
        'value' => [
            'male' => 'M',
            'female' => 'F',
        ]
    ],
    'tel_type' => [
        'name' => [
            'H' => '自宅',
            'K' => '携帯',
        ],
        'value' => [
            'home' => 'H',
            'mobile' => 'K',
        ]
    ],

    // 操作区分
    'status' => [
        'name' => [
            'B' => '旅行社',
            'C' => '個人',
        ],
        'value' => [
            'agent' => 'B',
            'end_user' => 'C',
        ]
    ],
    // 登録モード
    'insert_mode' => [
        'value' => [
            'check' => 'C',
            'force' => 'F',
        ]
    ],
    //食事希望
    'meal_request' => [
        'name' => [
            '0' => '希望なし',
            '1' => '1回目',
            '2' => '2回目',
        ],
        'value' => [
            'no_request' => '0',
            'first' => '1',
            'second' => '2',
        ]
    ],
    //子供食区分
    'child_meal_type' => [
        'name' => [
            'Y' => '要',
            'N' => '不要(大人食)',
            '' => '',
        ],
        'value' => [
            'yes' => 'Y',
            'no' => 'N',
        ]
    ],
    //幼児食区分
    'infant_meal_type' => [
        'name' => [
            'N' => '不要',
            'Y' => '昼・夕食(有料)',
            'D' => '夕食のみ(有料)',
        ],
        'value' => [
            'no' => 'N',
            'lunch_dinner' => 'Y',
            'dinner' => 'D',
        ]
    ],
    //詳細入力FLAG
    'detail_input_flag' => [
        'name' => [
            '0' => '未',
            '1' => '済',
        ],
        'value' => [
            'yet' => '0',
            'fin' => '1',
        ]
    ],
    //提出書類FLAG
    'submit_document_flag' => [
        'name' => [
            '0' => '-',
            '1' => '未',
            '2' => '-',
            '3' => '済',
        ],
        'value' => [
            'unanswered' => '0',
            'yet' => '1',
            'none' => '2',
            'fin' => '3',
        ]
    ],
    //子供食区分
    'answer_status' => [
        'value' => [
            'success' => 'S',
            'error' => 'E',
            'request' => 'R'
        ]
    ],
    // ファイル形式
    'file_type' => [
        'name' => [
            'C' => 'CSV',
            'E' => 'EXCEL',
        ],
        'extension' => [
            'C' => 'csv',
            'E' => 'xlsx',
        ],
        'value' => [
            'csv' => 'C',
            'excel' => 'E',
        ]
    ],
    // フォーマット編集フラグ
    'format_edit_flag' => [
        'value' => [
            'all' => 1,
            'copy' => 2,
            'not_possible' => 4,
        ]
    ],
    // 予約区分
    'reservation_type' => [
        'value' => [
            'general' => '1',
            'work' => '2',
            'hold_keep' => '3',
            'wait' => '4',
            'temp' => '5'
        ],
        'agent_name' => [
            '1' => '一般',
            '2' => '業務',
            '3' => '客室控え',
            '4' => 'キャンセル待ち',
            '5' => '一次'
        ],
        'user_name' => [
            '1' => '予約中',
            '4' => 'キャンセル待ち',
        ]
    ],
    // 予約ステータスF
    'reservation_status' => [
        'value' => [
            'wait' => 'WT',
            'cancel' => 'CX',
            'hold_keep' => 'hk',
        ]
    ],
    // 精算状況フラグ
    'pay_state' => [
        'value' => [
            'yet' => '0',
            'done' => '1',
            'part' => '2',
            'refund' => '3'
        ],
        'name' => [
            '0' => '未精算',
            '1' => '精算済み',
            '2' => '一部未精算',
            '3' => 'ご返金があります'
        ]
    ],
    // 提出書類区分フラグ
    'submit_document' => [
        'value' => [
            'question' => '0',
            'yet' => '1',
            'none' => '2',
            'done' => '3'
        ],
        'name' => [
            '0' => '質問に答えてください',
            '1' => '提出書類があります',
            '2' => '提出書類はありません',
            '3' => '提出書類提出済です',
        ]
    ],
    // 発券可能フラグ
    'ticketing' => [
        'value' => [
            'disabled' => '0',
            'possible' => '1',
        ]
    ],
    // 発券状況フラグ
    'ticket_state' => [
        'value' => [
            'yet' => '0',
            'done' => '1',
        ],
        'name' => [
            '0' => '乗船券印刷可',
            '1' => '乗船券印刷済',
        ]
    ],
    // 状況フラグ
    'state' => [
        'value' => [
            'active' => 'A',
            'delete' => 'D',
        ]
    ],
    // 予約取込の属性区分
    'reservation_import_attribute_type' => [
        'name' => [
            'C' => '文字',
            'N' => '数字',
            'D' => '日付',
            'R' => '客室タイプ',
            'S' => '性別',
            'Z' => '郵便番号',
            'T' => '電話番号',
            'P' => '都道府県',
            'A' => '大小幼区分',
            'U' => '半角英字大文字',
            'K' => '半角カナ',
        ]
    ],
    // レコード区分
    'record_status' => [
        'value' => [
            'begin' => '1',
            'data' => '2',
            'check' => '3',
            'finish' => '9',
        ]
    ],
    // 予約取込ステータス
    'reservation_import_status' => [
        'name' => [
            'HK' => 'HK',
            'WT' => 'WT',
            'CX' => 'CX',
            'ER' => 'エラー'
        ],
    ],
    // 予約取込処理区分
    'reservation_import_process_type' => [
        'name' => [
            '0' => '変更',
            '1' => '新規',
            '2' => '変更',
            '3' => '変更',
            '4' => '変更',
            '9' => '変更',
        ]
    ],
    //ネット入力区分
    'net_input_type' => [
        'name' => [
            '0' => '不可',
            '1' => 'ネット入力',
            '2' => 'ネット外部'
        ]
    ],
    //書類入手区分
    'document_get_type' => [
        'name' => [
            '0' => '不可',
            '1' => 'PDF',
            '2' => '書類後日郵送'
        ]
    ],
    //返信区分
    'answer_format' => [
        'name' => [
            'N' => '不要',
            'Y' => '要',
        ]
    ],
    //アップロード可
    'upload_possible' => [
        'name' => [
            'N' => '不可',
            'Y' => '可',
        ]
    ],
    //書類確認区分
    'document_check_type' => [
        'name' => [
            'N' => '未',
            'Y' => '済',
        ]
    ],
    //回答分類
    'answer_type' => [
        'name' => [
            '1' => '回答要',
            '2' => '回答不要',
            '3' => 'ご案内',
            '9' => 'システム',
        ],
        'class' => [
            '1' => 'delete',
            '2' => 'success',
            '3' => 'add',
        ]
    ],
    'tel_osaka' => [
        'name' => [
            'tel' => '06(6347)7521',
            'fax' => '06(6341)8980'
        ],
    ],
    'tel_tokyo' => [
        'name' => [
            'tel' => '03(5532)2211',
            'fax' => '03(5532)2212'
        ],
    ],
    'sentence' => [
        'value' => [
            'document' => '101',
            'cancel' => '121'
        ],
    ],
    // メール操作コード
    'mail_operation_code' => [
        'value' => [
            'agent_password_reset' => '264',
            'password_reset' => '121'
        ],
    ],
    //ご連絡一覧ソートクラス名
    'contact_sort_class' => [
        'name' => [
            'contact_date_asc' => 'asc',
            'contact_date_desc' => 'desc',
            'departure_date_asc' => 'asc',
            'departure_date_desc' => 'desc'
        ],
    ],
    // 郵便番号検索
    'address' => [
        'name' => [
            'not_posting' => '以下に掲載がない場合'
        ]
    ],
    //乗船券控え 食事回数
    'meal_done' => [
        'name' => [
            '0' => '',
            '1' => '1回目',
            '2' => '2回目'
        ]
    ],
    //乗船券控え 食事場所
    'meal_location' => [
        'name' => [
            'S' => 'ダイニングサロン',
            'M' => 'メインダイニング',
            'C' => 'メスルーム'
        ]
    ]
];