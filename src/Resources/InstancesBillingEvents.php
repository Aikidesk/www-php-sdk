<?php
namespace Aikidesk\SDK\WWW\Resources;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

/**
 * Class InstancesBillingEvents
 */
class InstancesBillingEvents
{

    /**
     * @var null|int
     */
    protected $instanceId = null;

    /**
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface
     */
    private $request;

    /**
     * Users constructor.
     * @param int|null $instanceId
     * @param \Aikidesk\SDK\WWW\Contracts\RequestInterface $request
     */
    public function __construct($instanceId = null, RequestInterface $request)
    {
        $this->setInstanceId($instanceId);
        $this->request = $request;
    }

    /**
     * Scopes: instance_billing_own, instance_billing_all
     *
     * @param array $data
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function create($data, $optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        $input['data'] = json_encode($data);

        return $this->request->post(sprintf('instance/%1d/billing/event', $instanceId), $input);
    }

    /**
     * @return int|null
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setInstanceId($id)
    {
        $this->instanceId = $id;

        return $this;
    }
}
