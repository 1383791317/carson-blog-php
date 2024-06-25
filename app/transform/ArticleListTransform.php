<?php

declare(strict_types=1);

namespace app\transform;

use app\models\article\ArticleTagModel;

class ArticleListTransform extends BaseTransform implements Transform
{
    public function transItem($item): array
    {
        $item['tags'] = $item->tags->column('name');
        $item = $item->toArray();
        $item['created_at'] = $this->dateFormat($item['created_at'], 'Y-m-d');
        return $item;
    }
}