<?php
namespace Aikidesk\SDK\WWW\Exceptions;

class BadRequestException extends ApiException
{
    /**
     * BadRequestException constructor.
     * @param string $msg
     * @param string $code
     * @param string $url
     * @param array $meta
     */
    public function __construct($msg = 'Bad Request', $code = '400', $url = '', $meta = [])
    {
        parent::__construct($msg, $code, $url, $meta);
    }
}
