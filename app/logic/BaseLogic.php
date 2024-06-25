<?php
declare(strict_types=1);

namespace app\logic;
class BaseLogic
{
    protected static $models = [];

    /**
     * 静态实例
     * @return static
     */
    public static function getInstance()
    {
        $name = get_called_class();
        if (!isset(self::$models[$name])) {
            self::$models[$name] = new $name();
        }
        return self::$models[$name];
    }
}