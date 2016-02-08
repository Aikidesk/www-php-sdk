<?php
namespace Aikidesk\WWW\Contracts;

/**
 * Interface RequestInterface
 */
interface RequestInterface
{
    /**
     * @param $access_token
     */
    public function setAccessToken($access_token);

    /**
     * @return string
     */
    public function getAccessToken();

    /**
     * @param string $uri
     * @param array $queryParams
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function get($uri, $queryParams = []);

    /**
     * @param string $uri
     * @param array $queryParams
     * @param array $headers
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function post($uri, $queryParams = [], $headers = []);

    /**
     * @param string $uri
     * @param array $queryParams
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function put($uri, $queryParams = []);

    /**
     * @param string $uri
     * @param array $queryParams
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function delete($uri, $queryParams = []);

    /**
     * @param $response
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function returnResponseObject($response);
}
