<?php

namespace Omnipay\Oppwa\Message;

class VoidRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        return array(
            'paymentType' => 'RV',
        );
    }

    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/payments/' . $this->getTransactionReference();
    }
}
