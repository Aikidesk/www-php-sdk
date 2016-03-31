<?php
namespace Aikidesk\SDK\WWW;

interface WwwSdkApiTokensInterface
{

    /**
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function current();

    /**
     * @param array $scopes
     * @return \Aikidesk\SDK\WWW\Contracts\Resp
     */
    public function createClientCredentialsToken($scopes = []);

    /**
     * @param string $email
     * @param string $password
     * @param array $scopes
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function createPasswordFlowToken($email, $password, $scopes = []);

    /**
     * @param string $refreshToken
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function createRefreshToken($refreshToken);

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token);

    /**
     * @return string
     */
    public function getAccessToken();

    /**
     * @return null|string
     */
    public function getOauthClientId();

    /**
     * @param null|string $oauthClientId
     */
    public function setOauthClientId($oauthClientId);

    /**
     * @return null|string
     */
    public function getOauthClientSecret();

    /**
     * @param null|string $oauthClientSecret
     */
    public function setOauthClientSecret($oauthClientSecret);
}
