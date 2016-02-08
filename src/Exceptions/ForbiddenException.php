<?php
namespace Aikidesk\WWW\Exceptions;

class ForbiddenException extends ApiException
{
    /**
     * ForbiddenException constructor.
     * @param string $msg
     * @param string $code
     * @param string $url
     * @param array $meta
     */
    public function __construct($msg = 'Forbidden', $code = '403', $url = '', $meta = [])
    {
        parent::__construct($msg, $code, $url, $meta);
    }
}
