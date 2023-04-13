<?php
namespace A406299736\GeneratorObject;
/**
 * User: Jin.s
 * Date: 2022/05/25 17:38
 * Mail: jin.aiyo@hotmail.com
 * Desc: 数据对象抽象类
 */

use A406299736\GeneratorObject\Exceptions\EmptyException;
use A406299736\GeneratorObject\Exceptions\UndefinedException;

abstract class DataObj
{
    private $originData = [];

    private $existsK = [];

    private $empty = false;

    public function __construct($data = [])
    {
        $this->originData = $data;
        if (!is_array($data)) $data = (array)$data;
        $this->setProperties($data);
        $this->check();
    }

    public function isEmpty()
    {
        return $this->empty;
    }

    /**
     * @return array
     */
    public function getOriginData(): array
    {
        return $this->originData;
    }

    // 请求原始数据key转化:驼峰->下划线
    public function conv2underlineWithOriginData()
    {
        $return = [];
        foreach ($this->originData as $key => $val) {
                $return[$this->unHump($key)] = $val;
        }

        return $return;
    }

    // 请求数据key转化:驼峰->下划线; 且不带有签名字段
    public function conv2underlineWithExistData()
    {
        $return = [];
        foreach ($this->existsK as $key) {
            $method = $this->methodName($key, 'get');
            if (method_exists($this, $method)) {
                $return[$this->unHump($key)] = call_user_func([$this, $method]);
            }
        }

        return $return;
    }

    /**
     * @desc 设置需要检测的必填参数
     * @param array $requiredCheckProperties
     * @return mixed
     */
    abstract protected function requiredCheckProperties() :array;

    public function withOptions(array $options)
    {
        $this->setProperties($options);
        return $this;
    }

    // 多维索引列表数组由子类对应的set方法实现
    private function setProperties(array $data)
    {
        if (empty($data)) {
            // 不考虑withOptions
            $this->empty = true;
            return;
        }
        foreach ((array)$data as $key => $val) {
            if (is_array($val) && !is_numeric($key)) {
                $class = ucfirst($this->hump($key)) . $this->objSuffix();
                $calledClass = get_called_class();
                $space = substr($calledClass, 0, strrpos($calledClass, '\\'));
                $class = $space . "\\{$class}";

                if (class_exists($class)) {
                    $c = new $class($val);
                    $this->setPropertyVal($key, $c);
                } else {
                    $this->setPropertyVal($key, $val);
                }
            } else {
                $this->setPropertyVal($key, $val);
            }
        }
    }

    private function setPropertyVal($key, $val)
    {
        // 对于变量val是多维索引数组时, 由相应子类的对应set方法实现返回具体对象的数组
        // 例如 [[1,2,3],[4,5,6]], [['a' => 1], ['b' => 2]] 等
        $method = $this->methodName($key, 'set');
        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $val);
            $this->existsK[] = $key;
        }
    }

    private function check()
    {
        $check = $this->requiredCheckProperties();
        if ($check && is_array($check)) {
            foreach ($check as $checkProperty) {
                $method = $this->methodName($checkProperty);
                if (!method_exists($this, $method)) {
                    throw new UndefinedException( "Undefined {$method} method");
                }
                $val = call_user_func([$this, $method]);
                if (!$val || empty($val)) {
                    throw new EmptyException("Empty value of {$checkProperty}");
                }
            }
        }
    }

    private function methodName($string, $fix = 'get')
    {
        if (strpos($string, '_') && $a = explode('_', $string)) {
            $method = $fix . ucfirst(array_shift($a));
            foreach ($a as $k) {
                $method .= ucfirst($k);
            }
        } else {
            $method = $fix . ucfirst($string);
        }

        return $method;
    }

    // key 生成数据对象默认类名后缀,比如: key=user, 生成数据对象时拼接: UserData
    // 且检查UserData是否存在
    protected function objSuffix()
    {
        return 'Data';
    }

    // 下划线转驼峰
    protected function hump($unHump, $separator = '_')
    {
        $unHump = $separator. str_replace($separator, " ", strtolower($unHump));
        return ltrim(str_replace(" ", "", ucwords($unHump)), $separator );
    }

    // 驼峰转下划线
    protected function unHump($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}
