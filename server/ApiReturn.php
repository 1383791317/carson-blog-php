<?php
declare (strict_types=1);

namespace server;

use server\code\ErrorCode;
use think\Response;

class ApiReturn
{
    const success = 1;
    const fail = 0;
    const confirm = 2;

    public static function success($data = [], $message = '操作成功')
    {
        return self::return(self::success, self::success, $message, $data);
    }

    public static function paginate($paginator, $transform = null)
    {
        return self::return(self::success, self::success, '表格数据', [
            'total' => $paginator->total(),
            'page_size' => $paginator->listRows(),
            'page' => $paginator->currentPage(),
            'data' => self::transItem($paginator, $transform)
        ]);
    }
    private static function transItem($paginator, $transform): array
    {
        if ($transform && class_exists($transform)){
            $data = [];
            foreach ($paginator->items() as $item) {
                $ite = (new $transform)->transItem($item);
                if ($ite) {
                    $data[] = $ite;
                }
            }
            return $data;
        }
        return $paginator->items();
    }
    public static function fail($code = null, $message = null, $data = [])
    {
        $code = $code ?: ErrorCode::operation_fail;
        if (isset(ErrorCode::$message[$code])) {
            $message = call_user_func_array('sprintf', [ErrorCode::$message[$code], $message]);
        } else {
            $message = ErrorCode::$message[ErrorCode::server_undefined_code];
        }
        return self::return(self::fail, $code, $message, $data);
    }

    public static function return($status, $code, $message = '', $data = [], $header = [])
    {
        return Response::create(compact('status', 'code', 'message', 'data'), 'json')->header($header);
    }
}