<?php
namespace Aikidesk\WWW;

use Aikidesk\WWW\Contracts\RequestInterface;

class Api
{
    /**
     * @var string
     */
    const BASE_URL = 'https://www.aikidesk.com/api';
    /**
     * @var string
     */
    const API_VERSION = '1.0';

    /**
     * @var \Aikidesk\WWW\Contracts\RequestInterface|null
     */
    protected $request = null;

    /**
     * @var \Aikidesk\WWW\Resources\OAuth
     */
    private $oauthResources;

    /**
     * Api constructor.
     * @param \Aikidesk\WWW\Contracts\RequestInterface $request
     * @param null $oauthResources
     */
    public function __construct(
        RequestInterface $request,
        $oauthResources = null
    ) {
        $this->request = $request;
        $this->oauthResources = $oauthResources ?: new \Aikidesk\WWW\Resources\OAuth($this->request);
//        $this->sessionResources = $sessionResources ?: new \Aikidesk\WWW\Resources\Sessions(null, $this->request);
//        $this->roomResources = $roomResources ?: new \Aikidesk\WWW\Resources\Rooms(null, $this->request);
//        $this->userResources = $userResources ?: new \Aikidesk\WWW\Resources\Users(null, $this->request);
    }

    /**
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $meta
     * @throws \Aikidesk\WWW\Exceptions\ApiException
     * @throws \Aikidesk\WWW\Exceptions\BadRequestException
     * @throws \Aikidesk\WWW\Exceptions\ForbiddenException
     * @throws \Aikidesk\WWW\Exceptions\InternalServerErrorException
     * @throws \Aikidesk\WWW\Exceptions\NotFoundException
     * @throws \Aikidesk\WWW\Exceptions\ServerUnavailableException
     * @throws \Aikidesk\WWW\Exceptions\UnauthorizedException
     */
    public static function throwException($code, $msg, $url = '', $meta = [])
    {
        switch ($code) {
            case 400:
                throw new \Aikidesk\WWW\Exceptions\BadRequestException($msg, $code, $url, $meta);
                break;
            case 401:
                throw new \Aikidesk\WWW\Exceptions\UnauthorizedException($msg, $code, $url, $meta);
                break;
            case 403:
                throw new \Aikidesk\WWW\Exceptions\ForbiddenException($msg, $code, $url, $meta);
                break;
            case 404:
                throw new \Aikidesk\WWW\Exceptions\NotFoundException($msg, $code, $url, $meta);
                break;
            case 500:
                throw new \Aikidesk\WWW\Exceptions\InternalServerErrorException($msg, $code, $url, $meta);
                break;
            case 503:
                throw new \Aikidesk\WWW\Exceptions\ServerUnavailableException($msg, $code, $url, $meta);
                break;
            default:
                throw new \Aikidesk\WWW\Exceptions\ApiException($msg, $code, $url, $meta);
        }
    }

    /**
     * @return \Aikidesk\WWW\Resources\OAuth
     */
    public function oauth()
    {
        return $this->oauthResources;
    }

    /*public function session($session_id = null)
    {
        $this->sessionResources->setId($session_id);

        return $this->sessionResources;
    }

    public function room($room_id = null)
    {
        $this->roomResources->setId($room_id);

        return $this->roomResources;
    }

    public function user($user_id = null)
    {
        $this->userResources->setId($user_id);

        return $this->userResources;
    }*/

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->request->setAccessToken($access_token);
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->request->getAccessToken();
    }
}
