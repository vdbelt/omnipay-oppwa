<?php

namespace Omnipay\Oppwa\Message;

class RefundRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference', 'amount', 'currency');

        return array(
            'paymentType' => 'RF',
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency()
        );
    }

    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/' . $this->getTransactionReference();
    }
}
