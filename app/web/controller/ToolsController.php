<?php
declare (strict_types=1);

namespace app\web\controller;
use app\BaseController;
use app\logic\tools\FanQieLogic;
use server\ApiReturn;

class ToolsController extends BaseController
{
    public function fanQie()
    {
        return ApiReturn::success(FanQieLogic::getInstance()->getArticleContent($this->request->post('url')));
    }
}