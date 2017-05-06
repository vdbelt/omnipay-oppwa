<?php

namespace Omnipay\Oppwa\Message;

class CaptureRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference', 'amount', 'currency');

        return array(
            'paymentType' => 'CP',
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency()
        );
    }

    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/' . $this->getTransactionReference();
    }
}
