<?php
/**
 * User: Jin's
 * Date: 2022/7/15 15:22
 * Mail: jin.aiyo@hotmail.com
 * Desc: TODO
 */

namespace A406299736\GeneratorObject;

class InstanceMaker
{
    private static $instance = [];

//    private function __construct(){}

    private function __clone() {}

    // 创建带有构造参数的实例时要特别注意该参数值会不会随着实例方法不同而改变.
    public static function getInstance($vars = null)
    {
        $called = get_called_class();
        if (!isset(self::$instance[$called]) || !(self::$instance[$called] instanceof self)) {
            self::$instance[$called] = new static($vars);
        }
        return self::$instance[$called];
    }
}
