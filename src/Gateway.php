<?php

namespace Omnipay\Oppwa;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Oppwa';
    }

    public function getDefaultParameters()
    {
        return array(
            'token' => '',
            'entityId' => ''
        );
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

    public function authorize(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\AuthorizeRequest', $options);
    }

    public function completeAuthorize(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\FetchTransactionRequest', $options);
    }

    public function capture(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\CaptureRequest', $options);
    }

    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\PurchaseRequest', $options);
    }

    public function completePurchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\FetchTransactionRequest', $options);
    }

    public function refund(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\RefundRequest', $options);
    }

    public function void(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\VoidRequest', $options);
    }

    public function acceptNotification(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\ServerNotifyRequest', $options);
    }

    public function fetchTransaction(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\FetchTransactionRequest', $options);
    }
}
