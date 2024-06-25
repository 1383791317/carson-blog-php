<?php

namespace server\exception;


use server\ApiReturn;
use server\code\ErrorCode;

class CentralizedException extends \Exception
{
    //错误码
    protected $errCode = 0;
    //返回数据
    protected $data = [];
    //异常类型
    protected $apiReturnStatus;
    //是否记录日志
    protected $isRecordLog = true;
    //是否发送通知
    protected $sendNotice = false;
    //报错描述
    protected $description = '';

    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        //初始化异常CODE
        $this->apiReturnStatus = ApiReturn::fail;

    }

    /**
     * 设置报错描述
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * 获取报错描述
     * @return mixed|string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * 设置发送通知
     * @return $this
     */
    public function openSendNotice()
    {
        $this->sendNotice = true;
        return $this;
    }

    /**
     * @return bool|mixed
     * @desc 获取发送通知设置
     */
    public function getSendNotice()
    {
        return $this->sendNotice;
    }

    /**
     * @return bool|mixed
     * @desc 获取记录日志
     */
    public function getRecordLog()
    {
        return $this->isRecordLog;
    }

    /**
     * @return $this
     * @desc 设置不记录日志
     */
    public function setRecordLogFalse()
    {
        $this->isRecordLog = false;
        return $this;
    }

    /**
     * @return int|mixed
     * @desc 获取错误码
     */
    public function getErrorCode()
    {
        return $this->errCode;
    }

    /**
     * @param $code
     * @return $this
     * @desc 设置错误码
     */
    public function setErrorCode($code)
    {
        $this->errCode = $code;
        return $this;
    }

    /**
     * @param $type
     * @return $this
     * @desc 设置异常类型
     */
    public function setApiReturnStatus($type)
    {
        $this->apiReturnStatus = $type;
        return $this;
    }

    /**
     * @return int
     * @desc 获取异常类型
     */
    public function getApiReturnStatus()
    {
        return $this->apiReturnStatus;
    }

    /**
     * @param $data
     * @return $this
     * @desc 设置数据
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return int|mixed
     * @desc 获取数据
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $code
     * @param $message
     * @return mixed
     * @desc 获取错误码对应的错误信息
     */
    protected static function getCodeMessage($code, $message)
    {
        $message = ($message && is_string($message)) ? $message : ErrorCode::$message[$code];
        return call_user_func_array('sprintf', [ErrorCode::$message[$code], $message]);
    }
}
