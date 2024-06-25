<?php
declare (strict_types=1);

namespace app\admin\controller\article;

use app\BaseController;
use app\models\article\ArticleTagModel;
use server\ApiReturn;
use server\code\ErrorCode;
use server\exception\ClientException;
use think\Request;

class TagController extends BaseController
{
    public function list(Request $request)
    {
        return ApiReturn::paginate(ArticleTagModel::query()->order('id', 'desc')->paginate(intval($request->get('limit', 10))));
    }

    public function save(Request $request)
    {
        $param = $request->post();
        $this->validate($param, [
            'name' => 'require|max:255|unique:article_tag,name',
        ], [
            'name.require' => '标签名称不能为空',
            'name.max' => '标签名称最大255个字符',
            'name.unique' => '标签名称已存在',
        ]);
        if (isset($param['id'])) {
            ArticleTagModel::update($param, ['id' => $param['id']]);
        } else {
            ArticleTagModel::create(['name' => $param['name']]);
        }
        return ApiReturn::success();
    }

    public function del(Request $request)
    {
        $find = ArticleTagModel::query()->findOrEmpty($request->delete('id'));
        if ($find->isEmpty()) ClientException::throwException(ErrorCode::validate_param_error, '标签数据不存在');
        $find->delete();
        return ApiReturn::success();
    }

    public function select()
    {
        return ApiReturn::success(ArticleTagModel::query()->field('id as value,name as label')->select());
    }
}