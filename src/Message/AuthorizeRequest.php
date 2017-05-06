<?php

namespace Omnipay\Oppwa\Message;

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
        return parent::getEndpoint() . '/payments';
    }
}
