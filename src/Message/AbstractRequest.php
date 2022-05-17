<?php

namespace Omnipay\Oppwa\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_VERSION = 'v1';

    protected $testEndpoint = 'https://test.oppwa.com';

    protected $liveEndpoint = 'https://oppwa.com';

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
        $params = array(
            'entityId' => $this->getEntityId()
        );

        $http_query = $this->getHttpMethod() === 'GET' ? '?' . http_build_query($params) : '';
        $body = $this->getHttpMethod() === 'POST' ? array_merge($params, $data) : null;

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint() . $http_query,
            array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' =>  'Bearer '.$this->getToken()
            ),
            $body ? http_build_query($body) : null
        );

        return $this->response = new Response(
            $this,
            json_decode($httpResponse->getBody(), true),
            $httpResponse->getStatusCode()
        );
    }
}
