<?php

namespace app\transform;

class BaseTransform
{
    //API 返回时间格式
    protected $date_format = 'Y-m-d H:i:s';

    public function dateFormat($value, $format = '')
    {
        return $value ? date($format ?: $this->date_format,strtotime($value)) : '';
    }
}
