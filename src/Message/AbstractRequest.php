<?php

namespace Omnipay\Oppwa\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_VERSION = 'v1';

    protected $testEndpoint = 'https://eu-test.oppwa.com';

    protected $liveEndpoint = 'https://eu-prod.oppwa.com';

    public function getIntegrationType()
    {
        return $this->getParameter('integrationType');
    }

    public function setIntegrationType($value)
    {
        return $this->setParameter('integrationType', $value);
    }

    public function getToken()
    {
        return $this->getParameter('token');
    }

    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }

    public function getEntityId()
    {
        return $this->getParameter('entityId');
    }

    public function setEntityId($value)
    {
        return $this->setParameter('entityId', $value);
    }

    protected function getEndpoint()
    {
        $base = $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
        return $base . '/' . self::API_VERSION;
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        $queryParams = array(
            'entityId' => $this->getEntityId()
        );

        $http_query = $this->getHttpMethod() == 'GET' ? '?' . http_build_query($queryParams) : '';

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint() . $http_query,
            array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' =>  'Bearer '.$this->getToken()
            ),
            http_build_query(array_merge(
                $queryParams,
                $data
            ))
        );

        return $this->response = new Response(
            $this,
            json_decode($httpResponse->getBody(), true),
            $httpResponse->getStatusCode()
        );
    }
}
