<?php
declare (strict_types = 1);

namespace server\exception;

use server\ApiReturn;
use server\code\ErrorCode;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        return match (true) {
            $e instanceof ValidateException => ApiReturn::fail(ErrorCode::validate_exception, $e->getError()),
            $e instanceof CentralizedException => $this->centralizedExceptions($request, $e),
            $e instanceof HttpException => ApiReturn::fail(ErrorCode::server_router_not_exist,data:[
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]),
            default => ApiReturn::fail(ErrorCode::server_error, $e->getMessage(),[
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]),
        };
    }
    public function centralizedExceptions($request, $e)
    {
        return ApiReturn::return($e->getApiReturnStatus(), $e->getErrorCode(), $e->getMessage(), $e->getData());
    }

}
