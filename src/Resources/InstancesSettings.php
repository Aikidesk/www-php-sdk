<?php
namespace Aikidesk\SDK\WWW\Resources;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

/**
 * Class InstancesSettings
 */
class InstancesSettings
{

    /**
     * @var null|int
     */
    protected $instanceId = null;

    /**
     * @var null|int
     */
    protected $settingId = null;

    /**
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface
     */
    private $request;

    /**
     * Users constructor.
     * @param int|null $instanceId
     * @param int|null $settingId
     * @param \Aikidesk\SDK\WWW\Contracts\RequestInterface $request
     */
    public function __construct($instanceId = null, $settingId = null, RequestInterface $request)
    {
        $this->setInstanceId($instanceId);
        $this->setSettingId($settingId);
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

        return $this->request->get(sprintf('instance/%1d/setting', $instanceId), $input);
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
     * @param string $key
     * @param string $value
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function create($key, $value, $optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        $input['key'] = $key;
        $input['value'] = $value;

        return $this->request->post(sprintf('instance/%1d/setting', $instanceId), $input);
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
        $settingId = $this->getSettingId();
        $input = [];
        if (isset($optional['with'])) {
            $input['with'] = $optional['with'];
        }

        return $this->request->get(sprintf('instance/%1d/setting/%1d', $instanceId, $settingId), $input);
    }

    /**
     * @return int|null
     */
    public function getSettingId()
    {
        return $this->settingId;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setSettingId($id)
    {
        $this->settingId = $id;

        return $this;
    }

    /**
     * Scopes Instance: instance_get_own, instance_get_all
     * Scopes: instance_system
     *
     * @param mixed $value
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function update($value, $optional = [])
    {
        $instanceId = $this->getInstanceId();
        $settingId = $this->getSettingId();
        $input = [];
        $input['value'] = $value;

        return $this->request->put(sprintf('instance/%1d/setting/%1d', $instanceId, $settingId), $input);
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
        $settingId = $this->getSettingId();
        $input = [];

        return $this->request->delete(sprintf('instance/%1d/setting/%1d', $instanceId, $settingId), $input);
    }
}
