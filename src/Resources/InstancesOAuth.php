<?php
namespace Aikidesk\SDK\WWW\Resources;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

/**
 * Class InstancesOAuth
 */
class InstancesOAuth
{

    /**
     * @var null|int
     */
    protected $instanceId = null;

    /**
     * @var null|int
     */
    protected $oauthId = null;

    /**
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface
     */
    private $request;

    /**
     * Users constructor.
     * @param int|null $instanceId
     * @param int|null $oauthId
     * @param \Aikidesk\SDK\WWW\Contracts\RequestInterface $request
     */
    public function __construct($instanceId = null, $oauthId = null, RequestInterface $request)
    {
        $this->setInstanceId($instanceId);
        $this->setOAuthId($oauthId);
        $this->request = $request;
    }

    /**
     * Scopes Instance: instance_get_own, instance_get_all
     * Scopes Instance OAuth: instance_oauth_get_own, instance_oauth_get_all
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

        return $this->request->get(sprintf('instance/%1d/oauth', $instanceId), $input);
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
     * Scopes: instance_create
     *
     * @param string $name
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function create($name, $optional = [])
    {
        $instanceId = $this->getInstanceId();
        $input = [];
        $input['name'] = $name;

        return $this->request->post(sprintf('instance/%1d/oauth', $instanceId), $input);
    }

    /**
     * Scopes Instance: instance_get_own, instance_get_all
     * Scopes Instance OAuth: instance_oauth_get_own, instance_oauth_get_all
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function get($optional = [])
    {
        $instanceId = $this->getInstanceId();
        $oauthId = $this->getOAuthId();
        $input = [];
        if (isset($optional['with'])) {
            $input['with'] = $optional['with'];
        }

        return $this->request->get(sprintf('instance/%1d/oauth/%2d', $instanceId, $oauthId), $input);
    }

    /**
     * @return int|null
     */
    public function getOAuthId()
    {
        return $this->oauthId;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setOAuthId($id)
    {
        $this->oauthId = $id;

        return $this;
    }

    /**
     * Scopes: instance_archive_own, instance_archive_all
     *
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function delete()
    {
        $instanceId = $this->getInstanceId();
        $oauthId = $this->getOAuthId();
        $input = [];

        return $this->request->delete(sprintf('instance/%1d/oauth/%2d', $instanceId, $oauthId), $input);
    }
}
