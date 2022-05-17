<?php

namespace Omnipay\Oppwa\Message;

use Omnipay\Oppwa\Gateway;

class AuthorizeRequest extends AbstractRequest
{
    public function getBankAccount()
    {
        return $this->getParameter('bankAccount');
    }

    public function setBankAccount($data)
    {
        return $this->setParameter('bankAccount', $data);
    }

    public function getCustomerGivenName()
    {
        return $this->getParameter('customerGivenName');
    }

    public function setCustomerGivenName($value)
    {
        return $this->setParameter('customerGivenName', $value);
    }

    public function getCustomerSurname()
    {
        return $this->getParameter('customerSurname');
    }

    public function setCustomerSurname($value)
    {
        return $this->setParameter('customerSurname', $value);
    }

    public function getCustomerEmail()
    {
        return $this->getParameter('customerEmail');
    }

    public function setCustomerEmail($value)
    {
        return $this->setParameter('customerEmail', $value);
    }

    public function getBillingCity()
    {
        return $this->getParameter('billingCity');
    }

    public function setBillingCity($value)
    {
        return $this->setParameter('billingCity', $value);
    }

    public function getBillingCountry()
    {
        return $this->getParameter('billingCountry');
    }

    public function setBillingCountry($value)
    {
        return $this->setParameter('billingCountry', $value);
    }

    public function getBillingState()
    {
        return $this->getParameter('billingState');
    }

    public function setBillingState($value)
    {
        return $this->setParameter('billingState', $value);
    }

    public function getBillingStreet()
    {
        return $this->getParameter('billingStreet');
    }

    public function setBillingStreet($value)
    {
        return $this->setParameter('billingStreet', $value);
    }

    public function getBillingPostCode()
    {
        return $this->getParameter('billingPostCode');
    }

    public function setBillingPostCode($value)
    {
        return $this->setParameter('billingPostCode', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'currency');

        $data = array(
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'paymentType' => 'PA',
            'merchantTransactionId' => $this->getTransactionId(),
            'descriptor' => $this->getDescription(),
            'shopperResultUrl' => $this->getReturnUrl(),
            'notificationUrl' => $this->getNotifyUrl(),
            'customer.ip' => $this->getClientIp()
        );

        $extra = array(
            'customer.givenName' => $this->getCustomerGivenName(),
            'customer.surname'  => $this->getCustomerSurname(),
            'customer.email'   => $this->getCustomerEmail(),
            'billing.country'   => $this->getBillingCountry(),
            'billing.city'  => $this->getBillingCity(),
            'billing.state' => $this->getBillingState(),
            'billing.postcode' => $this->getBillingPostCode(),
            'billing.street1' => $this->getBillingStreet()
        );

        $data = array_merge($data, array_filter($extra));

        if ($this->getBankAccount()) {
            foreach ($this->getBankAccount() as $key => $value) {
                $data['bankAccount.' . $key] = $value;
            }
        }

        if ($this->getPaymentMethod()) {
            $data['paymentBrand'] = strtoupper($this->getPaymentMethod());
        }

        if ($this->getCard()) {
            $data = array_merge($data, $this->getCardData());
        }

        return $data;
    }

    protected function getCardData()
    {
        $this->getCard()->validate();

        return array(
            'paymentBrand' => strtoupper($this->getBrand()),
            'card.holder' => $this->getCard()->getName(),
            'card.number' => $this->getCard()->getNumber(),
            'card.expiryMonth' => $this->getCard()->getExpiryDate('m'),
            'card.expiryYear' => $this->getCard()->getExpiryDate('Y'),
            'card.cvv' => $this->getCard()->getCvv()
        );
    }

    public function getBrand()
    {
        $mapper = [
            'mastercard' => 'master',
            'diners_club' => 'diners'
        ];

        if (array_key_exists($this->getCard()->getBrand(), $mapper)) {
            return $mapper[$this->getCard()->getBrand()];
        }

        return $this->getCard()->getBrand();
    }

    protected function getEndpoint()
    {
        if ($this->getIntegrationType() === Gateway::TYPE_SERVER_TO_SERVER) {
            return parent::getEndpoint() . '/payments';
        }

        if ($this->getIntegrationType() === Gateway::TYPE_COPY_AND_PASTE) {
            return parent::getEndpoint() . '/checkouts';
        }

        throw new \LogicException("Unknown integrationType {$this->getIntegrationType()}");
    }
}
