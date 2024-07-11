<?php
declare(strict_types=1);

namespace app\web\controller;

use app\BaseController;
use app\models\article\ArticleModel;
use app\transform\ArticleListTransform;
use server\ApiReturn;
use think\Request;

class ArticleController extends BaseController
{
    public function list(Request $request)
    {
        $model = ArticleModel::query()->with(['category','tags']);
        if ($request->get('category_id')){
            $model = $model->where('category_id', $request->get('category_id'));
        }
        if ($request->get('tag_id')){
            $model = $model->whereIn('id', function ($query) use ($request){
                $query->name('article_tag_relation')->field('article_id')->where('article_tag_id', $request->get('tag_id'));
            });
        }
        return ApiReturn::paginate($model->order('id','desc')->paginate(intval($request->get('limit'))),ArticleListTransform::class);
    }

    public function detail(Request $request)
    {
        return ApiReturn::success(ArticleModel::query()->with('tags')->findOrEmpty($request->get('id')));
    }
}