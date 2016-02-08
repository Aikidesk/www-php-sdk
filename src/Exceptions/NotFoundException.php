<?php
namespace Aikidesk\WWW\Exceptions;

class NotFoundException extends ApiException
{
    /**
     * NotFoundException constructor.
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
