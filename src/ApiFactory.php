<?php
namespace Aikidesk\WWW;

use Aikidesk\WWW\Exceptions\ApiException;
use GuzzleHttp\Client;
use Resty\Resty;

class ApiFactory
{

    /**
     * @var \Aikidesk\WWW\Contracts\RequestInterface
     */
    public static $httpClient = null;

    /**
     * @var \Aikidesk\WWW\Contracts\RequestInterface
     */
    public static $httpOAuthClient = null;

    /**
     * @var string
     */
    public static $baseUrl = Api::BASE_URL;

    /**
     * @return \Aikidesk\WWW\Api
     * @throws \Aikidesk\WWW\Exceptions\ApiException
     */
    public static function instance()
    {
        $http_client = self::createHttpClient();

        return new Api($http_client);
    }

    /**
     * @return \Aikidesk\WWW\HttpClients\GuzzleV6|\Aikidesk\WWW\HttpClients\RestyClient|null
     * @throws \Aikidesk\WWW\Exceptions\ApiException
     */
    public static function createHttpClient()
    {
        if (self::$httpClient !== null) {
            return self::$httpClient;
        }

        if (class_exists('GuzzleHttp\Client')) {
            self::$httpClient = new \Aikidesk\WWW\HttpClients\GuzzleV6(self::$baseUrl.'/1.0/');
        } elseif (class_exists('Resty\Resty')) {
            self::$httpClient = new \Aikidesk\WWW\HttpClients\RestyClient(self::$baseUrl.'/1.0/');
        } elseif (extension_loaded('curl') and class_exists('Curl\Curl')) {
            self::$httpClient = new \Aikidesk\WWW\HttpClients\PhpCurlClient(self::$baseUrl.'/1.0/');
        } else {
            throw new ApiException('There is no supported HTTP Client!', 999);
        }

        return self::$httpClient;
    }

    /**
     * @return \Aikidesk\WWW\ApiTokens
     * @throws \Aikidesk\WWW\Exceptions\ApiException
     */
    public static function instanceTokens()
    {
        $http_client = self::createOAuthHttpClient();

        return new ApiTokens($http_client);
    }

    /**
     * @return \Aikidesk\WWW\HttpClients\GuzzleV6|\Aikidesk\WWW\HttpClients\RestyClient|null
     * @throws \Aikidesk\WWW\Exceptions\ApiException
     */
    public static function createOAuthHttpClient()
    {
        if (self::$httpOAuthClient !== null) {
            return self::$httpOAuthClient;
        }

        if (class_exists('GuzzleHttp\Client')) {
            $client = new Client(array('base_uri' => self::$baseUrl.'/'));
            self::$httpOAuthClient = new \Aikidesk\WWW\HttpClients\GuzzleV6(self::$baseUrl, $client);
        } elseif (class_exists('Resty\Resty')) {
            $client = new Resty();
            $client->setBaseURL(self::$baseUrl.'/');
            self::$httpClient = new \Aikidesk\WWW\HttpClients\RestyClient(self::$baseUrl, $client);
        } elseif (extension_loaded('curl') and class_exists('Curl\Curl')) {
            $client = new \Curl\Curl(self::$baseUrl.'/');
            self::$httpClient = new \Aikidesk\WWW\HttpClients\PhpCurlClient(self::$baseUrl, $client);
        } else {
            throw new ApiException('There is no supported HTTP Client!', 999);
        }

        return self::$httpOAuthClient;
    }

    /**
     * @param $accessToken
     * @throws \Aikidesk\WWW\Exceptions\ApiException
     */
    public static function setAccessToken($accessToken)
    {
        $http_client = self::createHttpClient();
        $http_client->setAccessToken($accessToken);
    }
}
