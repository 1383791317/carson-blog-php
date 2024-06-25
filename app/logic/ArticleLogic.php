<?php
declare(strict_types=1);

namespace app\logic;

use app\models\article\ArticleModel;
use app\models\article\ArticleTagModel;
use server\code\ErrorCode;
use server\exception\ClientException;

class ArticleLogic extends BaseLogic
{
    public function getPaginateList($param)
    {
        return ArticleModel::query()->paginate($param['page_size'] ?? null)->each(function ($item){
            $item->category_name = $item->category?->name;
            $item->tags = ArticleTagModel::query()->whereIn('id', $item->tags)->column('name');
        });
    }
    public function saveArticle($param)
    {
        if (!$param['description']){
            $param['description'] = mb_substr(preg_replace('/<[^>]*>/', '',str_replace(array("\n", "\t","&nbsp;"), '', $param['content'])),0,350).'...';
        }
        if (isset($param['id'])){
            $article = ArticleModel::query()->findOrEmpty($param['id']);
            if ($article->isEmpty()) ClientException::throwException(ErrorCode::validate_param_error, '文章不存在');
            $article->save($param);
            $article->tags()->saveAll($param['tags']);
        }else{
            $article = ArticleModel::create($param);
            $article->tags()->saveAll($param['tags']);
        }
    }
}