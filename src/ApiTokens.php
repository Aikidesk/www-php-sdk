<?php
namespace Aikidesk\SDK\WWW;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

class ApiTokens implements WwwSdkApiTokensInterface
{
    /**
     * @var string
     */
    const BASE_URL = 'https://www.aikidesk.com/api';

    /**
     * @var string
     */
    const API_VERSION = 'oauth';

    /**
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface|null
     */
    protected $request = null;

    /**
     * @var string|null
     */
    private $oauthClientId = null;

    /**
     * @var string|null
     */
    private $oauthClientSecret = null;

    /**
     * ApiTokens constructor.
     * @param \Aikidesk\SDK\WWW\Contracts\RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
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
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function current()
    {
        return $this->request->get('test');
    }

    /**
     * @param array $scopes
     * @return \Aikidesk\SDK\WWW\Contracts\Resp
     */
    public function createClientCredentialsToken($scopes = [])
    {
        $oauthId = $this->getOauthClientId();
        $oauthSecret = $this->getOauthClientSecret();

        $postFormData = [
            'client_id' => $oauthId,
            'client_secret' => $oauthSecret,
            'grant_type' => 'client_credentials',
            'state' => 'PhEbakeb4azeqAtUPrewabuxUwruqahA',
            'scope' => implode(',', $scopes),
        ];

        return $this->request->post('oauth/client_credentials', $postFormData);
    }

    /**
     * @return null|string
     */
    public function getOauthClientId()
    {
        return $this->oauthClientId;
    }

    /**
     * @param null|string $oauthClientId
     */
    public function setOauthClientId($oauthClientId)
    {
        $this->oauthClientId = $oauthClientId;
    }

    /**
     * @return null|string
     */
    public function getOauthClientSecret()
    {
        return $this->oauthClientSecret;
    }

    /**
     * @param null|string $oauthClientSecret
     */
    public function setOauthClientSecret($oauthClientSecret)
    {
        $this->oauthClientSecret = $oauthClientSecret;
    }

    /**
     * @param string $email
     * @param string $password
     * @param array $scopes
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function createPasswordFlowToken($email, $password, $scopes = [])
    {
        if (count($scopes) <= 0) {
            $scopes[] = 'instance_login';
        }
        $oauthId = $this->getOauthClientId();
        $oauthSecret = $this->getOauthClientSecret();

        $postFormData = [
            'client_id' => $oauthId,
            'client_secret' => $oauthSecret,
            'grant_type' => 'password',
            'username' => $email,
            'password' => $password,
            'state' => 'PhEbakeb4azeqAtUPrewabuxUwruqahA',
            'scope' => implode(',', $scopes),
        ];

        return $this->request->post('oauth/password_flow', $postFormData);
    }

    /**
     * @param string $refreshToken
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function createRefreshToken($refreshToken)
    {
        $oauthId = $this->getOauthClientId();
        $oauthSecret = $this->getOauthClientSecret();

        $postFormData = [
            'client_id' => $oauthId,
            'client_secret' => $oauthSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'state' => 'PhEbakeb4azeqAtUPrewabuxUwruqahA',
        ];

        return $this->request->post('oauth/refresh_token', $postFormData);
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
