<?php

namespace Gigasavvy\Saffron\Contactually;

use GuzzleHttp\Client as GClient;

/**
 * Class Client
 * @package Gigasavvy\Saffron\Contactually
 */
class Client
{
    const USER_AGENT = 'php-contractually-wrapper';
    /**
     * @var string
     */
    private $baseURL = 'https://api.contactually.com';

    /**
     * @var string
     */
    private $apiKey = 'tm211hsvfhluf4nlqncb0cjj0evcf512';

    /**
     * @var GClient|null
     */
    protected $client = null;

    /**
     * @var null
     */
    protected $request = null;

    /**
     * @var null
     */
    public $response = null;

    /**
     * @var null
     */
    public $statusCode = null;

    /**
     * @var null
     */
    public $detail   = null;

    /**
     * Client constructor.
     * @param $apiKey
     * @param null $client
     */
    public function __construct($apiKey, $client = null)
    {
        $this->apiKey = $apiKey;
        $this->client = (is_null($client)) ? new GClient(
            ['base_uri' => $this->baseURL,
                'headers' => [
                'User-Agent' => $this::USER_AGENT . '/' . PHP_VERSION,
                'Authorization' => 'Bearer ' . $this->apiKey
                ]
            ]
        ) : $client;
    }

    /**
     * @param $uri
     * @param array $params
     * @return array|mixed|object
     */
    public function get($uri, $params = array())
    {
        $this->response = $this->client->get($uri, ['exceptions' => false, 'query' => $params]);
        $this->statusCode = $this->response->getStatusCode();
        $raw_body = $this->response->getBody();

        return json_decode($raw_body, true);
    }

    /**
     * @param $uri
     * @param array $params
     * @return array|mixed|object
     */
    public function patch($uri, $params = array())
    {
        $this->response = $this->client->request('PATCH', $uri, [
            'json' => [ 'data' => $params]
        ]);
        $this->statusCode = $this->response->getStatusCode();
        $raw_body = $this->response->getBody();

        return json_decode($raw_body, true);
    }

    /**
     * @param $uri
     * @param array $params
     * @return array|mixed|object
     */
    public function put($uri, $params = array())
    {

        $this->response = $this->client->put($uri, ['exceptions' => false, 'query' => $params]);
        $this->statusCode = $this->response->getStatusCode();
        $raw_body = $this->response->getBody();

        return json_decode($raw_body, true);
    }

    /**
     * @param $uri
     * @param array $params
     * @return bool|\GuzzleHttp\Stream\StreamInterface|null|\Psr\Http\Message\StreamInterface
     */
    public function post($uri, $params = array())
    {
        $this->response = $this->client->request('POST', $uri, [
            'json' => [ 'data' => $params]
        ]);

        $this->statusCode = $this->response->getStatusCode();

        if ($this->statusCode) {
            return $this->response->getBody();
        } else {
            return false;
        }
    }

    /**
     * @param $uri
     * @return bool|\GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|\GuzzleHttp\Ring\Future\FutureInterface|null|\Psr\Http\Message\ResponseInterface
     */
    public function delete($uri)
    {
        $this->response = $this->client->delete($uri, ['exceptions' => false, 'query' => $params]);
        $this->statusCode = $this->response->getStatusCode();

        if ($this->statusCode) {
            return $this->response;
        } else {
            return false;
        }
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exceptions\InvalidResource
     */
    public function __get($name)
    {
        $classname = ucwords(str_replace("_", " ", $name));
        $fullclass = "Gigasavvy\\Saffron\\Contactually\\" . str_replace(' ', '', $classname);

        if (class_exists($fullclass)) {
            return new $fullclass($this);
        }

        throw new \Gigasavvy\Saffron\Contactually\Exceptions\InvalidResource('Not supported');
    }
}
