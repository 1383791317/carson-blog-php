<?php
declare(strict_types=1);

namespace app\web\controller;

use app\BaseController;
use app\models\article\ArticleCategoryModel;
use app\models\article\ArticleTagModel;
use server\ApiReturn;
use think\Request;

class CategoryController extends BaseController
{
    public function info(Request $request)
    {
        $id = $request->get('id');
        $tagId = $request->get('tag_id');
        return ApiReturn::success([
            'category' => $id ? ArticleCategoryModel::query()->field('id,name')->findOrEmpty($id) : null,
            'tag' => $tagId ? ArticleTagModel::query()->field('id,name')->findOrEmpty($tagId) : null,
        ]);
    }
}