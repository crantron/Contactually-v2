<?php

namespace Gigasavvy\Saffron\Contactually;

/**
 * Class Contacts
 * @package Gigasavvy\Saffron\Contactually
 */
class Contacts extends Base
{
    /**
     * @var string
     */
    protected $resource = '/v2/contacts';

    /**
     * @var string
     */
    protected $dataname = 'contacts';

    /**
     * @param $email
     * @param $collection
     * @return array|bool
     */
    public function isMatchByEmail($email, $collection)
    {
        foreach ($collection['data'] as $contactKey => $contactValue) {
            foreach ($contactValue['email_addresses'] as $emailKey => $emailValue) {
                if (strtolower($email) == strtolower($emailValue['address'])) {
                    return [
                        'contact_id' => $contactValue['id'],
                        'handle' => strtolower($emailValue['address']),
                        'extra_data' => $contactValue['extra_data']
                    ];
                }
            }
        }

        return false;
    }

    /**
     * @param $contactId
     * @param $params
     * @return array|mixed|object
     */
    public function update($contactId, $params)
    {
        return $this->client->patch($this->resource . '/' .$contactId, $params);
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

    public function upsert(array $params)
    {
        $results = $this->client->post($this->resource.'?upsert=true', $params);
        $this->id = json_decode((string)$results)->data->id;
        return $results;
    }
    /**
     * @param $bucket_id
     * @param $id
     * @return bool|\GuzzleHttp\Stream\StreamInterface|null|\Psr\Http\Message\StreamInterface
     */
    public function bucket($bucket_id, $id)
    {
        $parameters = [['id' => $bucket_id]];

        $results = $this->client->post($this->resource . '/' . $id . '/buckets', $parameters);

        return $results;
    }
}
