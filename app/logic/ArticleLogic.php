<?php
declare(strict_types=1);

namespace app\logic;

use app\models\article\ArticleModel;
use app\models\article\ArticleTagModel;
use app\models\article\ArticleTagRelateModel;
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
            $old = $article->tags->column('id');
            $add = array_diff($param['tags'], $old);
            $del = array_diff($old, $param['tags']);
            if ($add){
                ArticleTagRelateModel::query()->insertAll(array_map(function ($id) use ($article) {
                    return [
                        'article_id' => $article->id,
                        'article_tag_id' => $id,
                    ];
                },$add));
            }
            if ($del){
                ArticleTagRelateModel::query()->where('article_id',$article->id)->whereIn('article_tag_id',$del)->delete();
            }
            $article->save($param);
        }else{
            $article = ArticleModel::create($param);
            $article->tags()->saveAll($param['tags']);
        }
    }
}