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
        $this->httpClient->getEventDispatcher()->addListener(
            'request.error',
            function ($event) {
                if ($event['response']->isClientError()) {
                    $event->stopPropagation();
                }
            }
        );

        $authentication = array(
            'authentication.userId' => $this->getUserId(),
            'authentication.password' => $this->getPassword(),
            'authentication.entityId' => $this->getEntityId()
        );

        $http_query = $this->getHttpMethod() == 'GET' ? '?' . http_build_query($authentication) : '';

        $httpRequest = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $this->getEndpoint() . $http_query,
            null,
            array_merge(
                $authentication,
                $data
            )
        );

        try {
            $httpRequest->getCurlOptions()->set(CURLOPT_SSLVERSION, 6);
            $httpResponse = $httpRequest->send();

            $body = $httpResponse->getBody(true);

            $jsonToArrayResponse = !empty($body) ? $httpResponse->json() : array();

            return $this->response = $this->createResponse($jsonToArrayResponse, $httpResponse->getStatusCode());
        } catch (\Exception $e) {
            throw new \Exception(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    protected function createResponse($data, $statusCode)
    {
        return $this->response = new Response($this, $data, $statusCode);
    }
}
