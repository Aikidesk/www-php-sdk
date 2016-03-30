<?php
namespace Aikidesk\SDK\WWW;

interface WwwSdkApiInterface
{

    /**
     * @return \Aikidesk\SDK\WWW\Resources\OAuth
     */
    public function oauth();

    /**
     * @param int|null $userId
     * @return \Aikidesk\SDK\WWW\Resources\Users
     */
    public function users($userId = null);

    /**
     * @param int|null $instanceId
     * @return \Aikidesk\SDK\WWW\Resources\Instances
     */
    public function instances($instanceId = null);

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token);

    /**
     * @return string
     */
    public function getAccessToken();
}
