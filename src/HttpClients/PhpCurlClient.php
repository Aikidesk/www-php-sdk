<?php
namespace Aikidesk\SDK\WWW\HttpClients;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;
use Aikidesk\SDK\WWW\Response;
use Resty\Resty;

/**
 * Class PhpCurlClient
 */
class PhpCurlClient implements RequestInterface
{

    protected $client = null;

    /**
     * @var string
     */
    protected $access_token = '';

    /**
     * @param string $baseUrl
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct($baseUrl, $client = null)
    {
        if ($client !== null) {
            $this->client = $client;

            return;
        }
        $client = new Resty();
        $client->setBaseURL($baseUrl);
        $this->client = $client;
    }

    /**
     * @param string $uri
     * @param array $queryParams
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function get($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('GET', $uri, $queryParams);

        return $this->processRequest($request);
    }

    /**
     * @param $method
     * @param $uri
     * @param $queryParams
     * @return array
     */
    private function prepareRequest($method, $uri, $queryParams)
    {
        $headers = array();

        if ($this->getAccessToken() !== null and !empty($this->getAccessToken())) {
            $headers['Authorization'] = 'Bearer '.$this->access_token;
        }

        switch ($method) {
            case 'GET':
                $request = $this->client->get($uri, $queryParams, $headers);
                break;
            case 'POST':
                $headers['Content-Type'] = 'application/json';
                $queryParams = json_encode($queryParams);
                $request = $this->client->post($uri, $queryParams, $headers);
                break;
            case 'PUT':
                $headers['Content-Type'] = 'application/json';
                $queryParams = json_encode($queryParams);
                $request = $this->client->put($uri, $queryParams, $headers);
                break;
            case 'DELETE':
                $headers['Content-Type'] = 'application/json';
                $request = $this->client->delete($uri, $queryParams, $headers);
                break;
        }

        return $request;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @param $request
     * @return mixed
     */
    private function processRequest($request)
    {
        if ($request['status'] == 200 or $request['status'] == 201 or $request['status'] == 204) {
            return $request;
        }
        $response_array = $this->objectToArray($request['body']);
        HipChat::throwException($response_array['error']['code'], $response_array['error']['message'],
            $request['meta']['uri']);
    }

    /**
     * @param $d
     * @return mixed
     */
    private function objectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }
        if (is_array($d)) {
            return array_map(array($this, __FUNCTION__), $d);
        } else {
            return $d;
        }
    }

    /**
     * @param array $response
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function returnResponseObject($response)
    {
        $return = new Response();
        $response_array = $this->objectToArray($response['body']);
        $return->setRateLimit($response['headers']['X-Ratelimit-Limit']);
        $return->setRateRemaining($response['headers']['X-Ratelimit-Remaining']);
        $return->setRateReset($response['headers']['X-Ratelimit-Reset']);
        $return->setData($response_array);
        $return->setResponseCode($response['status']);

        return $return;
    }

    /**
     * @param string $uri
     * @param array $queryParams
     * @param array $headers
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function post($uri, $queryParams = array(), $headers = array())
    {
        $request = $this->prepareRequest('POST', $uri, $queryParams);

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function put($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('PUT', $uri, $queryParams);

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function delete($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('DELETE', $uri, $queryParams);

        return $this->processRequest($request);
    }
}
