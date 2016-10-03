<?php
namespace Aikidesk\SDK\WWW;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

class Api implements WwwSdkApiInterface
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
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface|null
     */
    protected $request = null;

    /**
     * @var \Aikidesk\SDK\WWW\Resources\OAuth
     */
    private $oauthResources;

    /**
     * @var \Aikidesk\SDK\WWW\Resources\Users
     */
    private $usersResources;

    /**
     * @var \Aikidesk\SDK\WWW\Resources\Instances
     */
    private $instancesResources;

    /**
     * Api constructor.
     * @param \Aikidesk\SDK\WWW\Contracts\RequestInterface $request
     * @param null $oauthResources
     * @param null $usersResources
     * @param null $instancesResources
     */
    public function __construct(
        RequestInterface $request,
        $oauthResources = null,
        $usersResources = null,
        $instancesResources = null
    ) {
        $this->request = $request;
        $this->oauthResources = $oauthResources ?: new \Aikidesk\SDK\WWW\Resources\OAuth($this->request);
        $this->usersResources = $usersResources ?: new \Aikidesk\SDK\WWW\Resources\Users(null, $this->request);
        $this->instancesResources = $instancesResources ?: new \Aikidesk\SDK\WWW\Resources\Instances(null, null, null,
            null, null, null, $this->request);
    }

    /**
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $meta
     * @throws \Aikidesk\SDK\WWW\Exceptions\ApiException
     * @throws \Aikidesk\SDK\WWW\Exceptions\BadRequestException
     * @throws \Aikidesk\SDK\WWW\Exceptions\ForbiddenException
     * @throws \Aikidesk\SDK\WWW\Exceptions\InternalServerErrorException
     * @throws \Aikidesk\SDK\WWW\Exceptions\NotFoundException
     * @throws \Aikidesk\SDK\WWW\Exceptions\ServerValidationException
     * @throws \Aikidesk\SDK\WWW\Exceptions\BadGatewayException
     * @throws \Aikidesk\SDK\WWW\Exceptions\ServerUnavailableException
     * @throws \Aikidesk\SDK\WWW\Exceptions\UnauthorizedException
     */
    public static function throwException($code, $msg, $url = '', $meta = [])
    {
        switch ($code) {
            case 400:
                throw new \Aikidesk\SDK\WWW\Exceptions\BadRequestException($msg, $code, $url, $meta);
                break;
            case 401:
                throw new \Aikidesk\SDK\WWW\Exceptions\UnauthorizedException($msg, $code, $url, $meta);
                break;
            case 403:
                throw new \Aikidesk\SDK\WWW\Exceptions\ForbiddenException($msg, $code, $url, $meta);
                break;
            case 404:
                throw new \Aikidesk\SDK\WWW\Exceptions\NotFoundException($msg, $code, $url, $meta);
                break;
            case 422:
                throw new \Aikidesk\SDK\WWW\Exceptions\ServerValidationException($msg, $code, $url, $meta);
                break;
            case 500:
                throw new \Aikidesk\SDK\WWW\Exceptions\InternalServerErrorException($msg, $code, $url, $meta);
                break;
            case 502:
                throw new \Aikidesk\SDK\WWW\Exceptions\BadGatewayException($msg, $code, $url, $meta);
                break;
            case 503:
                throw new \Aikidesk\SDK\WWW\Exceptions\ServerUnavailableException($msg, $code, $url, $meta);
                break;
            default:
                throw new \Aikidesk\SDK\WWW\Exceptions\ApiException($msg, $code, $url, $meta);
        }
    }

    /**
     * @return \Aikidesk\SDK\WWW\Resources\OAuth
     */
    public function oauth()
    {
        return $this->oauthResources;
    }

    /**
     * @param int|null $userId
     * @return \Aikidesk\SDK\WWW\Resources\Users
     */
    public function users($userId = null)
    {
        $this->usersResources->setId($userId);

        return $this->usersResources;
    }

    /**
     * @param int|null $instanceId
     * @return \Aikidesk\SDK\WWW\Resources\Instances
     */
    public function instances($instanceId = null)
    {
        $this->instancesResources->setId($instanceId);

        return $this->instancesResources;
    }

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
