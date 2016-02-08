<?php
namespace Aikidesk\WWW\Resources;

use Aikidesk\WWW\Contracts\RequestInterface;

class OAuth
{

    /**
     * @var \Aikidesk\WWW\Contracts\RequestInterface
     */
    private $request;

    /**
     * OAuth constructor.
     * @param \Aikidesk\WWW\Contracts\RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function current()
    {
        return $this->request->get('test');
    }
}
