<?php
declare (strict_types=1);

namespace app\admin\controller\article;

use app\BaseController;
use app\logic\UploadLogic;
use server\ApiReturn;
use think\Request;

class CommonController extends BaseController
{
    public function uploadImage(Request $request)
    {
        return ApiReturn::success(UploadLogic::getInstance()->image($request->post('scene'),$request->file('binary')));
    }
}