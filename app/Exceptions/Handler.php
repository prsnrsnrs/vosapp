<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function response;
use function view;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception $exception
     * @return JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {

        // 開発時はエラーハンドリングさせない
        if (!config('app.debug')) {

            if ($exception instanceof ValidationException && $request->wantsJson() || $exception instanceof TokenMismatchException) {
                // ajax通信のバリデーション又は、トークンミスマッチは例外処理に含めない
                return parent::render($request, $exception);
            }

            $message = 'エラーが発生しました。';
            $status = 500;
            if ($exception instanceof HttpException) {
                switch ($exception->getStatusCode()) {
                    case 401:
                        $message = '認証に失敗しました。';
                        $status = 401;
                        break;
                    case 403:
                        $message = 'アクセスできません。';
                        $status = 403;
                        break;
                    case 404:
                        $message = 'ページが見つかりません。';
                        $status = 404;
                        break;
                }
            }

            if ($request->wantsJson()) {
                return response()->json(['messages' => $message], $status);
            } else {
                return response()->make(view("error." . $status, ['message' => $message]));
            }
        }
        return parent::render($request, $exception);
    }
}
