<?php
namespace Aikidesk\SDK\WWW\Resources;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

/**
 * Class InstancesUser
 */
class InstancesUser
{

    /**
     * @var null|int
     */
    protected $instanceId = null;

    /**
     * @var null|int
     */
    protected $userId = null;

    /**
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface
     */
    private $request;

    /**
     * Users constructor.
     * @param int|null $instanceId
     * @param int|null $userId
     * @param \Aikidesk\SDK\WWW\Contracts\RequestInterface $request
     */
    public function __construct($instanceId = null, $userId = null, RequestInterface $request)
    {
        $this->setInstanceId($instanceId);
        $this->setUserId($userId);
        $this->request = $request;
    }

    /**
     * Scopes Instance: instance_get_own, instance_get_all
     * Scopes: instance_system
     *
     * @param array $filter
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function all($filter = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];

        if (isset($filter['page'])) {
            $input['page'] = $filter['page'];
        }

        if (isset($filter['with'])) {
            $input['with'] = $filter['with'];
        }

        return $this->request->get(sprintf('instance/%1d/user', $instanceId), $input);
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
     * Scopes Instance: instance_get_own, instance_get_all
     * Scopes: instance_system
     *
     * @param int $userId
     * @param int $roleId
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function create($userId, $roleId, $optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        $input['user'] = $userId;
        $input['role'] = $roleId;

        return $this->request->post(sprintf('instance/%1d/user', $instanceId), $input);
    }

    /**
     * Scopes Instance: instance_get_own, instance_get_all
     * Scopes instance_system
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function get($optional = [])
    {
        $instanceId = $this->getInstanceId();
        $userId = $this->getUserId();
        $input = [];
        if (isset($optional['with'])) {
            $input['with'] = $optional['with'];
        }

        return $this->request->get(sprintf('instance/%1d/user/%1d', $instanceId, $userId), $input);
    }

    /**
     * @return int|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setUserId($id)
    {
        $this->userId = $id;

        return $this;
    }

    /**
     * Scopes Instance: instance_get_own, instance_get_all
     * Scopes: instance_system
     *
     * @param int $roleId
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function update($roleId, $optional = [])
    {
        $instanceId = $this->getInstanceId();
        $userId = $this->getUserId();
        $input = [];
        $input['role'] = $roleId;

        return $this->request->post(sprintf('instance/%1d/user/%1d', $instanceId, $userId), $input);
    }

    /**
     * Scopes Instance: instance_get_own, instance_get_all
     * Scopes: instance_system
     *
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function delete()
    {
        $instanceId = $this->getInstanceId();
        $userId = $this->getUserId();
        $input = [];

        return $this->request->delete(sprintf('instance/%1d/user/%1d', $instanceId, $userId), $input);
    }
}
