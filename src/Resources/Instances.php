<?php
namespace Aikidesk\SDK\WWW\Resources;

use Aikidesk\SDK\WWW\Contracts\RequestInterface;

/**
 * Class Instances
 */
class Instances
{

    /**
     * @var null|int
     */
    protected $id = null;

    /**
     * @var \Aikidesk\SDK\WWW\Resources\InstancesOAuth
     */
    private $instancesOAuth;

    /**
     * @var \Aikidesk\SDK\WWW\Contracts\RequestInterface
     */
    private $request;

    /**
     * @var \Aikidesk\SDK\WWW\Resources\InstancesUsers
     */
    private $instancesUsers;

    /**
     * @var \Aikidesk\SDK\WWW\Resources\InstancesBillingEvents
     */
    private $instancesBillingEvents;

    /**
     * @var \Aikidesk\SDK\WWW\Resources\InstancesStatsInternal
     */
    private $instanceStatInternal;

    public function __construct(
        RequestInterface $request,
        $instanceId = null,
        InstancesOAuth $instancesOAuth = null,
        InstancesUsers $instancesUser = null,
        InstancesSettings $instanceSetting = null,
        InstancesBillingEvents $instanceBillingEvents = null,
        InstancesStatsInternal $instanceStatInternal = null
    ) {
        $this->setId($instanceId);
        $this->instancesOAuth = $instancesOAuth;
        if ($this->instancesOAuth === null) {
            $this->instancesOAuth = new InstancesOAuth($request, $this->getId(), null);
        }

        $this->instancesUsers = $instancesUser;
        if ($this->instancesUsers === null) {
            $this->instancesUsers = new InstancesUsers($request, $this->getId(), null);
        }

        $this->instancesSettings = $instanceSetting;
        if ($this->instancesSettings === null) {
            $this->instancesSettings = new InstancesSettings($request, $this->getId(), null);
        }

        $this->instancesBillingEvents = $instanceBillingEvents;
        if ($this->instancesBillingEvents === null) {
            $this->instancesBillingEvents = new InstancesBillingEvents($request, $this->getId());
        }

        $this->instanceStatInternal = $instanceStatInternal;
        if ($this->instanceStatInternal === null) {
            $this->instanceStatInternal = new InstancesStatsInternal($request, $this->getId());
        }

        $this->request = $request;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Scopes: instance_get_own, instance_get_all
     *
     * @param array $filter
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function all($filter = [])
    {
        $input = [];

        if (isset($filter['page'])) {
            $input['page'] = $filter['page'];
        }

        if (isset($filter['archived'])) {
            $input['archived'] = $filter['archived'];
        }

        if (isset($filter['status'])) {
            $input['status'] = $filter['status'];
        }

        if (isset($filter['version'])) {
            $input['version'] = $filter['version'];
        }

        if (isset($filter['user'])) {
            $input['user'] = $filter['user'];
        }

        if (isset($filter['timezone'])) {
            $input['timezone'] = $filter['timezone'];
        }

        if (isset($filter['locale'])) {
            $input['locale'] = $filter['locale'];
        }

        if (isset($filter['created_at'])) {
            $input['created_at'] = $filter['created_at'];
        }

        if (isset($filter['with'])) {
            $input['with'] = $filter['with'];
        }

        return $this->request->get('instance', $input);
    }

    /**
     * Scopes: instance_create
     *
     * @param string $name
     * @param string $subdomain
     * @param string $timezone
     * @param string $locale
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function create($name, $subdomain, $timezone, $locale, $optional = [])
    {
        $input = [];
        $input['name'] = $name;
        $input['subdomain'] = $subdomain;
        $input['timezone'] = $timezone;
        $input['locale'] = $locale;

        if (isset($optional['user_id'])) {
            $input['user_id'] = $optional['user_id'];
        }

        return $this->request->post('instance', $input);
    }

    /**
     * Scopes: instance_create
     *
     * @param string $subdomain
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function checkDomainAvailability($subdomain, $optional = [])
    {
        $input = [];
        $input['subdomain'] = $subdomain;

        return $this->request->post('instance/domain_availability', $input);
    }

    /**
     * Scopes: instance_get_own, instance_get_all
     *
     * @param array $optional
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function get($optional = [])
    {
        $instanceId = $this->getId();
        $input = [];
        if (isset($optional['with'])) {
            $input['with'] = $optional['with'];
        }

        return $this->request->get(sprintf('instance/%1d', $instanceId), $input);
    }

    /**
     * Scopes: instance_archive_own, instance_archive_all
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function archive()
    {
        $instanceId = $this->getId();
        $input = [];

        return $this->request->put(sprintf('instance/%1d/archive', $instanceId), $input);
    }

    /**
     * Scopes: instance_recover_own, instance_recover_all
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function recover()
    {
        $instanceId = $this->getId();
        $input = [];

        return $this->request->put(sprintf('instance/%1d/recover', $instanceId), $input);
    }

    /**
     * Scopes: instance_delete_own, instance_delete_all
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function delete()
    {
        $instanceId = $this->getId();
        $input = [];

        return $this->request->delete(sprintf('instance/%1d', $instanceId), $input);
    }

    /**
     * Scopes: instance_system
     * @param int $userId
     * @param int $role
     * @return \Aikidesk\SDK\WWW\Contracts\ResponseInterface
     */
    public function systemGrantUser($userId, $role)
    {
        $instanceId = $this->getId();
        $input = [];
        $input['user_id'] = $userId;
        $input['role'] = $role;

        return $this->request->put(sprintf('instance/%1d/systemGrantUser', $instanceId), $input);
    }

    /**
     * @param null|int $oauthId
     * @return \Aikidesk\SDK\WWW\Resources\InstancesOAuth
     */
    public function oauth($oauthId = null)
    {
        $this->instancesOAuth->setInstanceId($this->getId());
        $this->instancesOAuth->setOAuthId($oauthId);

        return $this->instancesOAuth;
    }

    /**
     * @param null|int $userId
     * @return \Aikidesk\SDK\WWW\Resources\InstancesUsers
     */
    public function user($userId = null)
    {
        $this->instancesUsers->setInstanceId($this->getId());
        $this->instancesUsers->setUserId($userId);

        return $this->instancesUsers;
    }

    /**
     * @param null|int $settingId
     * @return \Aikidesk\SDK\WWW\Resources\InstancesUsers
     */
    public function setting($settingId = null)
    {
        $this->instancesSettings->setInstanceId($this->getId());
        $this->instancesSettings->setSettingId($settingId);

        return $this->instancesSettings;
    }

    /**
     * @return \Aikidesk\SDK\WWW\Resources\InstancesBillingEvents
     */
    public function billingEvent()
    {
        $this->instancesBillingEvents->setInstanceId($this->getId());

        return $this->instancesBillingEvents;
    }

    /**
     * @return \Aikidesk\SDK\WWW\Resources\InstancesStatsInternal
     */
    public function statInternal()
    {
        $this->instanceStatInternal->setInstanceId($this->getId());

        return $this->instanceStatInternal;
    }
}
