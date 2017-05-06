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
            'userId' => '',
            'password' => '',
            'entityId' => ''
        );
    }

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

    public function authorize(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\AuthorizeRequest', $options);
    }

    public function capture(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\CaptureRequest', $options);
    }

    public function purchase(array $options = array())
    {
        return $this->createRequest('\Omnipay\Oppwa\Message\PurchaseRequest', $options);
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
