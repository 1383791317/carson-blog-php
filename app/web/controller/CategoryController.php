<?php
declare(strict_types=1);

namespace app\web\controller;

use app\BaseController;
use app\models\article\ArticleCategoryModel;
use server\ApiReturn;
use think\Request;

class CategoryController extends BaseController
{
    public function info(Request $request)
    {
        $id = $request->get('id');
        return ApiReturn::success(ArticleCategoryModel::query()->findOrEmpty($id));
    }
}