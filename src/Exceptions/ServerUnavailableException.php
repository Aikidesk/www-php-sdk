<?php
namespace Aikidesk\WWW\Exceptions;

class ServerUnavailableException extends ApiException
{
    /**
     * ServerUnavailableException constructor.
     * @param string $msg
     * @param string $code
     * @param string $url
     * @param array $meta
     */
    public function __construct($msg = 'Server Unavailable', $code = '503', $url = '', $meta = [])
    {
        parent::__construct($msg, $code, $url, $meta);
    }
}
