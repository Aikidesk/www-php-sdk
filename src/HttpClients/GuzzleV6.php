<?php
namespace Aikidesk\SDK\WWW\HttpClients;

use Aikidesk\SDK\WWW\Api;
use Aikidesk\SDK\WWW\Contracts\RequestInterface;
use Aikidesk\SDK\WWW\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class GuzzleV6
 */
class GuzzleV6 implements RequestInterface
{

    /**
     * @var \GuzzleHttp\Client|null
     */
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
        $client = new Client(array('base_uri' => $baseUrl));
        $this->client = $client;
    }

    /**
     * @param string $uri
     * @param array $queryParams
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function get($uri, $queryParams = array())
    {
        $options = [];
        $options['json'] = $queryParams;

        $request = new Request('GET', $uri, ['Accept' => 'application/json']);
        $rawResponse = $this->processResponse($request, $options);

        return $this->returnResponseObject($rawResponse);
    }

    /**
     * @param \GuzzleHttp\Psr7\Request $request
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function processResponse(Request $request, $options = [])
    {
        try {
            if ($this->getAccessToken() !== null and !empty($this->getAccessToken())) {
                $request = $request->withHeader('Authorization', 'Bearer '.$this->getAccessToken());
            }
            $response = $this->client->send($request, $options);
        } catch (TransferException $e) {
            VarDumper::dump((string) $e->getResponse()->getBody());
            if ($e->getResponse() !== null and $e->getResponse()->getBody() !== null) {
                $json_exception = json_encode($e->getResponse()->getBody(), true);
                if ($json_exception === false) {
                    return null;
                }
                $httpCode = $e->getResponse()->getStatusCode();
                $errorMsg = '';
                if (isset($json_exception['error_message'])) {
                    $errorMsg = $json_exception['error_message'];
                } else {
                    if (isset($json_exception['error'])) {
                        $errorMsg = $json_exception['error'];
                    }
                }
                Api::throwException($httpCode, $errorMsg, $request->getUri());
//                VarDumper::dump((string)$e->getResponse()->getBody());
                exit;
            }
        }

        return $response;
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
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Aikidesk\Api\WWW\Contracts\ResponseInterface
     */
    public function returnResponseObject($response)
    {
        $return = new Response();
        $return->setRateLimit($response->getHeader('X-RateLimit-Limit'));
        $return->setRateRemaining($response->getHeader('X-RateLimit-Remaining'));
        $return->setRateReset($response->getHeader('X-RateLimit-Reset'));
        $return->setData(json_decode($response->getBody(), true));
        $return->setResponseCode($response->getStatusCode());

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
        $options = [];
        $options['json'] = $queryParams;

        $request = new Request('POST', $uri, ['Accept' => 'application/json']);
        $rawResponse = $this->processResponse($request, $options);

        return $this->returnResponseObject($rawResponse);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function put($uri, $queryParams = array())
    {
        $options = [];
        $options['json'] = $queryParams;

        $request = new Request('PUT', $uri, ['Accept' => 'application/json']);
        $rawResponse = $this->processResponse($request, $options);

        return $this->returnResponseObject($rawResponse);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function delete($uri, $queryParams = array())
    {
        $options = [];

        $request = new Request('DELETE', $uri, ['Accept' => 'application/json']);
        $rawResponse = $this->processResponse($request, $options);

        return $this->returnResponseObject($rawResponse);
    }
}
