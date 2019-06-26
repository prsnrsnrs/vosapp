<?php

namespace App\Http\Services;

use App\Libs\DateUtil;
use App\Queries\MailQuery;
use App\Queries\PasswordQuery;
use App\Queries\SocketQuery;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * サービスの基底クラスです。
 * @package App\Services
 */
abstract class BaseService
{

    /**
     * レスポンスデータ
     * @var mixed
     */
    protected $response_data;

    /**
     * エラーメッセージ
     * @var array
     */
    private $error_messages;


    /**
     * コンストラクタ
     * BaseService constructor.
     */
    public function __construct()
    {
        $this->response_data = [];
        $this->error_messages = ['web' => null, 'socket' => null];
        $this->init();
    }

    /**
     * サービスを初期化します。
     * 必要に応じてサブクラスでオーバーライドしてください。
     */
    protected function init()
    {
    }

    /**
     * サービスの実行処理。
     * サブクラスでオーバーライドしてください。
     * @return mixed
     */
    public abstract function execute();

    /**
     * 返すデータを取得します。
     * @return array
     */
    public function getResponseData()
    {
        return $this->response_data;
    }

    /**
     * リダイレクト先に表示する成功メッセージをセットします。
     * @param $message
     */
    public function setRedirectSuccessMessage($message)
    {
        session()->flash('success_message', $message);
    }

    /**
     * ソケットのエラーメッセージをセットします
     * @param $message
     */
    public function setErrorMessage($message)
    {
        $this->error_messages['web'] = $message;
    }


    /**
     * 警告メッセージをセットします
     * @param $event_number
     */
    public function setSocketErrorMessages($event_number)
    {
        // 重複するメッセージを除外し、キーを再発番する。
        $messages = array_values(array_unique($this->getEventMessages($event_number), SORT_REGULAR));
        $this->error_messages['socket'] = $messages;
    }


    /**
     * イベントメッセージをDBから取得します
     * @param $event_number
     * @return array
     */
    protected function getEventMessages($event_number)
    {
        $socket = new SocketQuery();
        return $socket->findByEventNumber($event_number);
    }


    /**
     * エラーメッセージを返します。
     * @return array
     */
    public function getErrorMessages()
    {
        \Log::debug('エラーメッセージ', (array)$this->error_messages);
        if (request()->ajax()) {
            if (is_array($this->error_messages['web'])) {
                $this->error_messages['web'] = implode('<br/>', array_flatten($this->error_messages['web']));
            }

            if (is_array($this->error_messages['socket'])) {
                $this->error_messages['socket'] = implode('<br/>', array_flatten($this->error_messages['socket']));
            }
            return ['errors' => $this->error_messages];
        } else {
            return ['errors' => $this->error_messages];
        }
    }

    /**
     * 処理が成功したかどうか返します。
     * @return bool
     */
    public function isSuccess()
    {
        return is_null($this->error_messages['web']) && is_null($this->error_messages['socket']);
    }

    /**
     * メール認証キー生成
     * @param $pram
     * @return array
     */
    protected function createMailAuthKey($pram)
    {
        $query = new MailQuery();
        $key = $query->findByMailAuthKey($pram);
        if(isset($key[0])){
            return['mail_auth_key'=>""];
        }else{
            return['mail_auth_key'=>$pram];
        }
    }

    /**
     * メール認証キーが有効でアクセス可能なメール認証情報を返します。
     * アクセスできない場合は、403エラーを返します。
     * @param $auth_key
     * @param $operation_code
     * @return array
     * @throws AccessDeniedHttpException
     */
    protected function getAccessibleMailAuth($auth_key, $operation_code)
    {
        $query = new MailQuery();
        $mail_auth = $query->findByMailAuthKey($auth_key);
        $message = "";
        if (!$mail_auth) {
            $message = "メール認証情報の取得失敗";
        } else if ($mail_auth['auth_finish_date_time']) {
            $message = "認証済みのメール認証情報";
        } else if ((int)$mail_auth['auth_term_date_time'] < (int)DateUtil::now('YmdHis')) {
            $message = "有効期限切れのメール認証情報";
        } else if ($mail_auth['operation_code'] !== $operation_code) {
            $message = "期待する操作コードが異なるメール認証情報";
        }

        if ($message) {
            \Log::debug($message, ['auth_key' => $auth_key]);
            throw new AccessDeniedHttpException();
        }
        return $mail_auth;
    }
}