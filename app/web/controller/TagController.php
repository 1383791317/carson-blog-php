<?php
declare (strict_types=1);

namespace app\web\controller;

use app\BaseController;
use app\models\article\ArticleTagModel;
use server\ApiReturn;
use think\Request;

class TagController extends BaseController
{
    public function all()
    {
        return ApiReturn::success(ArticleTagModel::query()->field('id,name')->select());
    }
    public function info(Request $request)
    {
        $id = $request->get('id');
        return ApiReturn::success(ArticleTagModel::query()->findOrEmpty($id));
    }
}