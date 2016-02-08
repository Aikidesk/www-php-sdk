<?php
namespace Aikidesk\WWW\Exceptions;

class UnauthorizedException extends ApiException
{
    /**
     * UnauthorizedException constructor.
     * @param string $msg
     * @param string $code
     * @param string $url
     * @param array $meta
     */
    public function __construct($msg = 'Unauthorized', $code = '401', $url = '', $meta = [])
    {
        parent::__construct($msg, $code, $url, $meta);
    }
}
