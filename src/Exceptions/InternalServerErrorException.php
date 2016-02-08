<?php
namespace Aikidesk\WWW\Exceptions;

class InternalServerErrorException extends ApiException
{
    /**
     * InternalServerErrorException constructor.
     * @param string $msg
     * @param string $code
     * @param string $url
     * @param array $meta
     */
    public function __construct($msg = 'Internal Server Error', $code = '500', $url = '', $meta = [])
    {
        parent::__construct($msg, $code, $url, $meta);
    }
}
