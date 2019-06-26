<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * VOSS予約システムで
 * Class VossMail
 * @package App\Mail
 */
class VossMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    protected $view_params;
    /**
     * @var string
     */
    protected $view_name;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $attach_file_path;

    /**
     * Create a new message instance.
     * @param array $options
     *     "view_name" => テンプレート
     *     "view_params" => viewファイルにバインドするパラメータ
     *     "subject" => メール件名
     *     "type" => "text" or "html"
     *     "attach_file_path" => 添付ファイルパス
     * @return void
     */
    public function __construct($options)
    {
        $this->view_name = array_get($options, 'view', "");
        $this->view_params = array_get($options, 'view_params', []);
        $this->type = array_get($options, 'type', "text");
        $this->attach_file_path = array_get($options, 'attach_file_path', '');
        $this->subject = array_get($options, 'subject', "");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type === 'text') {
            $this->text($this->view_name, $this->view_params);
        } else {
            $this->view($this->view_name, $this->view_params);
        }

        if ($this->attach_file_path) {
            $this->attach($this->attach_file_path);
        }
        return $this;
    }

    /**
     * メール本文を返します。
     * @return string
     */
    public function getBodyText()
    {
        return \View::make($this->view_name, $this->view_params)->render();
    }
}
