<?php
namespace Aikidesk\WWW\Resources;

use Aikidesk\WWW\Contracts\RequestInterface;

/**
 * Class Users
 */
class Users
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
     * @param int|null $userId
     * @param \Aikidesk\WWW\Contracts\RequestInterface $request
     */
    public function __construct($userId = null, RequestInterface $request)
    {
        $this->setId($userId);
        $this->request = $request;
    }

    /**
     * Scopes: user_get_own, user_get_all
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

        if (isset($filter['created_at'])) {
            $input['created_at'] = $filter['created_at'];
        }

        return $this->request->get('user', $input);
    }

    /**
     * Scopes: user_create
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array $optional
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function create($name, $email, $password, $optional = [])
    {
        $input = [];
        $input['name'] = $name;
        $input['email'] = $email;
        $input['password'] = $password;

        if (isset($optional['locale'])) {
            $input['locale'] = $optional['locale'];
        }

        if (isset($optional['activated'])) {
            $input['activated'] = $optional['activated'];
        }

        return $this->request->post('user', $input);
    }

    /**
     * Scopes: user_get_own, user_get_all
     *
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function get()
    {
        $user_id = $this->getId();
        $input = [];

        return $this->request->get(sprintf('user/%1sd', $user_id), $input);
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
     * Scopes: user_search_id
     *
     * @param string $email
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     * @throws \Aikidesk\WWW\Exceptions\ApiException
     */
    public function searchByEmail($email)
    {
        return $this->request->get('user/email', ['email' => $email]);
    }

    /**
     * * Scopes: instance_system
     *
     * @param string $oldPassword
     * @param string $newPassword
     * @return \Aikidesk\WWW\Contracts\ResponseInterface
     */
    public function changePassword($oldPassword, $newPassword)
    {
        $user_id = $this->getId();
        $input = [];
        $input['oldPassword'] = $oldPassword;
        $input['newPassword'] = $newPassword;
        $input['newPassword_confirmation'] = $newPassword;

        return $this->request->put(sprintf('user/%1sd/password', $user_id), $input);
    }
}