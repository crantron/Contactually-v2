<?php

namespace Gigasavvy\Saffron\Contactually;

/**
 * Class Base
 * @package Gigasavvy\Saffron\Contactually
 */
abstract class Base
{
    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var
     */
    protected $id;

    /**
     * Base constructor.
     * @param Client $client
     */
    public function __construct(\Gigasavvy\Saffron\Contactually\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $id
     * @return $this
     */
    public function load($id)
    {
        $results = $this->client->get($this->resource . '/' . $id . '.json');
        $this->bind($results);

        return $this;
    }

    /**
     * @param array $params
     * @return array|mixed|object
     */
    public function query($params = [])
    {
        $params = 'with_archive=true&q=' . $params;
        $results = $this->client->get($this->resource, $params);
        return $results;
    }

    /**
     * @param array $params
     * @return bool|\GuzzleHttp\Stream\StreamInterface|null|\Psr\Http\Message\StreamInterface
     */
    public function create(array $params)
    {
        $results = $this->client->post($this->resource, $params);
        $this->id = json_decode((string)$results)->data->id;
        return $results;
    }
}
