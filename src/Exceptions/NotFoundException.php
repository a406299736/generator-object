<?php
/**
 * User: Jin's
 * Date: 2022/6/13 18:08
 * Mail: jin.aiyo@hotmail.com
 * Desc: TODO
 */

namespace A406299736\GeneratorObject\Exceptions;

class NotFoundException extends CustomException
{
    public function __construct(
        $message = "", $code = 12000,
        $data = [], \Throwable $previous = null
    ){
        if (!$message) $message = '未发现';
        parent::__construct($message, $code, $data, $previous);
    }
}
