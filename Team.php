<?php

namespace Gigasavvy\Saffron\Contactually;

/**
 * Class Team
 * @package Gigasavvy\Saffron\Contactually
 */
class Team extends Base
{
    /**
     * @var string
     */
    protected $resource = "/v2/team";

    protected $resourceUsers = "/v2/team/users";

    protected $resourceCustomFields = "/v2/team/custom-fields";

    /**
     * @var string
     */
    protected $dataname = "team";

    /**
     * @param array $parameters
     * @return array|mixed|object
     */
    public function getUsers($parameters = array())
    {
        return $this->client->get($this->resourceUsers, $parameters);
    }

    /**
     * @param $email
     * @param $collection
     * @return bool
     */
    public function getUserByEmail($email, $collection)
    {
        foreach ($collection['data'] as $key => $value) {
            if ($email == $value['email']) {
                return $value;
            }
        }

        return false;
    }

    /**
     * @return bool|\GuzzleHttp\Stream\StreamInterface|null|\Psr\Http\Message\StreamInterface
     */
    public function getCustomFields()
    {
        return $this->client->get($this->resourceCustomFields, array());
    }
}
