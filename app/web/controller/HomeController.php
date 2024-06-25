<?php
declare(strict_types=1);

namespace app\web\controller;

use app\BaseController;
use app\models\article\ArticleCategoryModel;
use server\ApiReturn;

class HomeController extends BaseController
{
    public function menus()
    {

        $items = ArticleCategoryModel::query()->select();
        $data = [];
        foreach ($items as $item){
            if ($item['parent_id'] == 0) {
                $data[$item->id]['label'] =  $item['name'];
                $data[$item->id]['title'] =  $item['name'];
                $data[$item->id]['key'] =  $item['id'];
            }else{
                $data[$item['parent_id']]['children'][] = [
                    'label' => $item['name'],
                    'title' => $item['name'],
                    'key' => $item->id,
                ];
            }
        }
        return ApiReturn::success(array_values($data));
    }
}