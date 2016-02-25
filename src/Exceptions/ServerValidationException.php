<?php
namespace Aikidesk\SDK\WWW\Exceptions;

class ServerValidationException extends ApiException
{
    /**
     * ServerValidationException constructor.
     * @param string $msg
     * @param string $code
     * @param string $url
     * @param array $meta
     */
    public function __construct($msg = 'Not Found', $code = '404', $url = '', $meta = [])
    {
        parent::__construct($msg, $code, $url, $meta);
    }
}
