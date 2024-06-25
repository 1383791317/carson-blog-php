<?php
declare (strict_types=1);

namespace app\admin\controller\article;

use app\BaseController;
use app\logic\ArticleLogic;
use app\models\article\ArticleModel;
use server\ApiReturn;
use think\Request;

class ArticleController extends BaseController
{
    public function list(Request $request)
    {
        return ApiReturn::paginate(ArticleLogic::getInstance()->getPaginateList($request->get()));
    }
    public function save(Request $request)
    {
        $param = $request->post();
        $this->validate($param, [
            'title' => 'require|max:255',
            'category_id' => 'require|number',
            'tags' => 'require|array',
            'content' => 'require',
        ], [
            'title.require' => '标题不能为空',
            'title.max' => '标题最大255个字符',
            'category_id.require' => '分类不能为空',
            'category_id.number' => '分类必须为数字',
            'tags.require' => '标签不能为空',
            'tags.array' => '标签必须为数组',
            'content.require' => '内容不能为空',
        ]);
        ArticleLogic::getInstance()->saveArticle($param);
        return ApiReturn::success();
    }

    public function detail(Request $request)
    {
        $article = ArticleModel::query()->findOrEmpty($request->get('id'));
        $article->tags = $article->tags->column('id');
        return ApiReturn::success($article);
    }
}