<?php
declare(strict_types=1);

namespace app\models\article;

use app\models\BaseModel;

class ArticleModel extends BaseModel
{
    protected $name = 'article';

    public function category()
    {
        return $this->belongsTo(ArticleCategoryModel::class, 'category_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(ArticleTagModel::class, 'article_tag_relation', 'article_tag_id', 'article_id');
    }
}
