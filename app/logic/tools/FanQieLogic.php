<?php
declare(strict_types=1);

namespace app\logic\tools;

use app\logic\BaseLogic;
use GuzzleHttp\Client;
use server\code\ErrorCode;
use server\exception\ClientException;

class FanQieLogic extends BaseLogic
{
    public function getArticleContent($body)
    {
        $query = parse_url($body)['query'] ?? [];
        if (!isset($query) || !$query) ClientException::throwException(ErrorCode::validate_operation_error,'传入链接异常');
        parse_str($query, $queryArray);
        $query = [
            'aid' => $queryArray['aid'],
            'book_id' => $queryArray['book_id'],
            'share_code' => $queryArray['share_code'],
            'share_type' => $queryArray['share_type'],
            'share_id' => $queryArray['share_id'],
            'addQueryPrefix' => true
        ];
        $content = file_get_contents('https://changdunovel.com/reading/bookapi/share/detail/v1?' . http_build_query($query));
        if (!$content){
            ClientException::throwException(ErrorCode::validate_operation_error,'获取内容失败');
        }
        $content = json_decode($content, true);
        $new = [];
        foreach ($content['data']['contents'] as $key=>$val){
            $val = str_replace("<p></p>","\n",$val);
            $val = str_replace("<p>","",$val);
            $val = str_replace("</p>","\n",$val);
            $new[] = [
                'title' => $content['data']['item_names'][$key],
                'content' => $val
            ];
        }
        return ['content'=>$new,'abstract'=>$content['data']['abstract']];
    }
}