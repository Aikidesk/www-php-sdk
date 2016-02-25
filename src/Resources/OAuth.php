<?php
namespace Aikidesk\SDK\WWW\Resources;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

class OAuth
{

    /**
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface
     */
    private $request;

    /**
     * OAuth constructor.
     * @param \Aikidesk\SDK\WWW\Contracts\RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function current()
    {
        return $this->request->get('test');
    }
}
