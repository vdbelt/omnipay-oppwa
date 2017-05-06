<?php

namespace Omnipay\Oppwa\Message;

class PurchaseRequest extends AuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['paymentType'] = 'DB';

        return $data;
    }
}
