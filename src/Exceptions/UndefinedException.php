<?php
/**
 * User: Jin's
 * Date: 2022/7/19 17:07
 * Mail: jin.aiyo@hotmail.com
 * Desc: TODO
 */

namespace A406299736\GeneratorObject\Exceptions;

class UndefinedException extends CustomException
{
    public function __construct(
        $message = "", $code = 13000,
        $data = [], \Throwable $previous = null
    ){
        if (!$message) $message = '未定义';
        parent::__construct($message, $code, $data, $previous);
    }
}
