<?php

namespace Omnipay\Oppwa\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_VERSION = 'v1';

    protected $testEndpoint = 'https://test.oppwa.com';

    protected $liveEndpoint = 'https://oppwa.com';

    public function getUserId()
    {
        return $this->getParameter('userId');
    }

    public function setUserId($value)
    {
        return $this->setParameter('userId', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
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
        $authentication = array(
            'authentication.userId' => $this->getUserId(),
            'authentication.password' => $this->getPassword(),
            'authentication.entityId' => $this->getEntityId()
        );

        $http_query = $this->getHttpMethod() == 'GET' ? '?' . http_build_query($authentication) : '';

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint() . $http_query,
            array(),
            http_build_query(array_merge(
                $authentication,
                $data
            ))
        );

        return $this->response = new Response($this, json_decode($httpResponse->getBody(), true), $httpResponse->getStatusCode());
    }
}
