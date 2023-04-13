<?php
/**
 * User: Jin's
 * Date: 2022/6/14 10:31
 * Mail: jin.aiyo@hotmail.com
 * Desc: 空异常
 */

namespace A406299736\GeneratorObject\Exceptions;

class EmptyException extends NotFoundException
{
    public function __construct(
        $message = "", $code = 11000,
        $data = [], \Throwable $previous = null
    ){
        if (!$message) $message = '数据为空';
        parent::__construct($message, $code, $data, $previous);
    }
}
