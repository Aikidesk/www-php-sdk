<?php
namespace Aikidesk\SDK\WWW\Resources;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

/**
 * Class InstancesStatsInternal
 */
class InstancesStatsInternal
{

    /**
     * @var null|int
     */
    protected $instanceId = null;

    /**
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface
     */
    private $request;

    public function __construct(RequestInterface $request, $instanceId = null)
    {
        $this->setInstanceId($instanceId);
        $this->request = $request;
    }

    /**
     * Scopes: instance_system
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function sendMonthlyUserCount($optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        if (is_array($optional)) {
            $input = array_merge($input, $optional);
        }

        return $this->request->post(sprintf('instance/%1d/stats-internal/monthly/user-count', $instanceId), $input);
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

    /**
     * Scopes: instance_system
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function sendMonthlyDepartmentCount($optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        if (is_array($optional)) {
            $input = array_merge($input, $optional);
        }

        return $this->request->post(sprintf('instance/%1d/stats-internal/monthly/department-count', $instanceId), $input);
    }

    /**
     * Scopes: instance_system
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function sendMonthlyOrganizationCount($optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        if (is_array($optional)) {
            $input = array_merge($input, $optional);
        }

        return $this->request->post(sprintf('instance/%1d/stats-internal/monthly/organization-count', $instanceId), $input);
    }

    /**
     * Scopes: instance_system
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function sendMonthlyTicketMessageCount($optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        if (is_array($optional)) {
            $input = array_merge($input, $optional);
        }

        return $this->request->post(sprintf('instance/%1d/stats-internal/monthly/ticket-message-count', $instanceId), $input);
    }

    /**
     * Scopes: instance_system
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function sendMonthlyTicketReceivedCount($optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        if (is_array($optional)) {
            $input = array_merge($input, $optional);
        }

        return $this->request->post(sprintf('instance/%1d/stats-internal/monthly/ticket-received-count', $instanceId), $input);
    }

    /**
     * Scopes: instance_system
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function sendMonthlyTicketRespondedCount($optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        if (is_array($optional)) {
            $input = array_merge($input, $optional);
        }

        return $this->request->post(sprintf('instance/%1d/stats-internal/monthly/ticket-responded-count', $instanceId), $input);
    }
}
