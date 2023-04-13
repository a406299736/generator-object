<?php
/**
 * User: Jin's
 * Date: 2022/6/13 17:50
 * Mail: jin.aiyo@hotmail.com
 * Desc: 自定义异常处理类
 */

namespace A406299736\GeneratorObject\Exceptions;


class CustomException extends \Exception
{
    protected $code;

    protected $msg;

    protected $data;

    public function __construct($message = "", $code = 1, $data = [], \Throwable $previous = null)
    {
        $this->code = $code;
        $this->msg = $message;
        $this->data = $data;

        parent::__construct($message, $code, $previous);
    }
}
