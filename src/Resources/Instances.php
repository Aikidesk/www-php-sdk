<?php
namespace Aikidesk\WWW\Resources;

use Aikidesk\WWW\Contracts\RequestInterface;

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
     * @var \Aikidesk\WWW\Contracts\RequestInterface
     */
    private $request;

    /**
     * Users constructor.
     * @param int|null $instanceId
     * @param \Aikidesk\WWW\Contracts\RequestInterface $request
     */
    public function __construct($instanceId = null, RequestInterface $request)
    {
        $this->setId($instanceId);
        $this->request = $request;
    }

    /**
     * Scopes: instance_get_own, instance_get_all
     *
     * @param array $filter
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
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
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
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
     * Scopes: instance_get_own, instance_get_all
     *
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function get()
    {
        $instance_id = $this->getId();
        $input = [];

        return $this->request->get(sprintf('instance/%1s', $instance_id), $input);
    }

    /**
     * Scopes: instance_archive_own, instance_archive_all
     *
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function archive()
    {
        $instance_id = $this->getId();
        $input = [];

        return $this->request->delete(sprintf('instance/%1s', $instance_id), $input);
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
}
