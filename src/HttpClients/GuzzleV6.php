<?php
namespace Aikidesk\SDK\WWW\HttpClients;

use Aikidesk\SDK\WWW\Api;
use Aikidesk\SDK\WWW\Contracts\RequestInterface;
use Aikidesk\SDK\WWW\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

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
     * @param string                  $baseUrl
     * @param \GuzzleHttp\Client|null $client
     */
    public function __construct($baseUrl, $client = null)
    {
        if ($client !== null) {
            $this->client = $client;

            return;
        }
        $client = new Client(['base_uri' => $baseUrl, 'timeout' => 5, 'connect_timeout' => 1]);
        $this->client = $client;
    }

    /**
     * @param string $uri
     * @param array  $queryParams
     *
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function get($uri, $queryParams = [])
    {
        $options = [];
        $options['json'] = $queryParams;

        $request = new Request('GET', $uri, ['Accept' => 'application/json']);
        $rawResponse = $this->processResponse($request, $options);

        return $this->returnResponseObject($rawResponse);
    }

    /**
     * @param \GuzzleHttp\Psr7\Request $request
     * @param array                    $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function processResponse(Request $request, $options = [])
    {
        try {
            if ($this->getAccessToken() !== null and !empty($this->getAccessToken())) {
                $request = $request->withHeader('Authorization', 'Bearer ' . $this->getAccessToken());
            }
            $response = $this->client->send($request, $options);
        } catch (RequestException $e) {
            $rawResponse = $e->getResponse();

            $httpCode = 500;
            $errorMsg = '';
            $meta = [];
            if ($rawResponse instanceof ResponseInterface) {
                $httpCode = $e->getResponse()->getStatusCode();
                $json_exception = json_encode($e->getResponse()->getBody(), true);
                if ($json_exception === false) {
                    $httpCode = $e->getCode();
                    $errorMsg = $e->getMessage();
                } else {
                    if (isset($json_exception['error_message'])) {
                        $errorMsg = $json_exception['error_message'];
                    } else {
                        if (isset($json_exception['error'])) {
                            $errorMsg = $json_exception['error'];
                        }
                    }
                }
                $meta = ['body' => (string) $e->getResponse()->getBody()];
            }

            $meta['prevException'] = $e;
            Api::throwException($httpCode, $errorMsg, $request->getUri(), $meta);
        } catch (TransferException $e) {
            $meta['prevException'] = $e;
            Api::throwException($httpCode, $errorMsg, $request->getUri(), $meta);
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
     *
     * @return \Aikidesk\Api\WWW\Contracts\ResponseInterface
     */
    public function returnResponseObject($response)
    {
        $return = new Response();
        $return->setRateLimit($response->getHeader('X-RateLimit-Limit'));
        $return->setRateRemaining($response->getHeader('X-RateLimit-Remaining'));
        $return->setRateReset($response->getHeader('Retry-After'));
        $return->setPlainBody($response->getBody()->getContents());
        $return->setData(json_decode($response->getBody(), true));
        $return->setResponseCode($response->getStatusCode());

        return $return;
    }

    /**
     * @param string $uri
     * @param array  $queryParams
     * @param array  $headers
     *
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function post($uri, $queryParams = [], $headers = [])
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
     *
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function put($uri, $queryParams = [])
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
     *
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function delete($uri, $queryParams = [])
    {
        $options = [];

        $request = new Request('DELETE', $uri, ['Accept' => 'application/json']);
        $rawResponse = $this->processResponse($request, $options);

        return $this->returnResponseObject($rawResponse);
    }
}
