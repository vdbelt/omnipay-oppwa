<?php

namespace Omnipay\Oppwa\Message;

use Omnipay\Oppwa\Gateway;

class FetchTransactionRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('transactionReference');

        return array();
    }

    protected function getHttpMethod()
    {
        return 'GET';
    }

    protected function getEndpoint()
    {
        if ($this->getIntegrationType() === Gateway::TYPE_SERVER_TO_SERVER) {
            return parent::getEndpoint() . '/payments/' . $this->getTransactionReference();
        }

        if ($this->getIntegrationType() === Gateway::TYPE_COPY_AND_PASTE) {
            return parent::getEndpoint() . '/checkouts/' . $this->getTransactionReference().'/payment';
        }

        throw new \LogicException("Unknown integrationType {$this->getIntegrationType()}");
    }
}
