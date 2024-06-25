<?php
declare (strict_types=1);

namespace app\admin\controller\article;

use app\BaseController;
use app\models\article\ArticleCategoryModel;
use server\ApiReturn;
use server\code\ErrorCode;
use server\exception\ClientException;
use think\Request;

class CategoryController extends BaseController
{
    public function list(Request $request)
    {
        return ApiReturn::paginate(ArticleCategoryModel::query()->order('id', 'desc')->where('parent_id',0)->paginate(intval($request->get('limit', 10)))->each(function ($item) {
            $item->children = ArticleCategoryModel::query()->order('id', 'desc')->where('parent_id', $item->id)->select();
        }));
    }

    public function save(Request $request)
    {
        $param = $request->post();
        $this->validate($param, [
            'name' => 'require|max:255|unique:article_category,name',
        ], [
            'name.require' => '分类名称不能为空',
            'name.max' => '分类名称最大255个字符',
            'name.unique' => '分类名称已存在',
        ]);
        if (isset($param['id'])) {
            ArticleCategoryModel::update($param, ['id' => $param['id']]);
        } else {
            ArticleCategoryModel::create(['name' => $param['name'],'parent_id' => $param['parent_id'] ?: 0]);
        }
        return ApiReturn::success();
    }

    public function del(Request $request)
    {
        $find = ArticleCategoryModel::query()->findOrEmpty($request->delete('id'));
        if ($find->isEmpty()) ClientException::throwException(ErrorCode::validate_param_error, '分类数据不存在');
        $find->delete();
        return ApiReturn::success();
    }

    public function parent()
    {
        return ApiReturn::success(ArticleCategoryModel::query()->where('parent_id', 0)->field('id as value,name as label')->select());
    }

    public function select()
    {
        $items = ArticleCategoryModel::query()->order('id', 'desc')->select();
        $data = [];
        foreach ($items as $item){
            if ($item['parent_id'] == 0) {
                $data[$item->id]['label'] =  $item['name'];
                $data[$item->id]['value'] =  $item['id'];
            }else{
                $data[$item['parent_id']]['options'][] = [
                    'label' => $item['name'],
                    'value' => $item->id,
                ];
            }
        }
        return ApiReturn::success(array_values($data));
    }
}