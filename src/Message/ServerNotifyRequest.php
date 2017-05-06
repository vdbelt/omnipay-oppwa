<?php

namespace Omnipay\Oppwa\Message;

use Omnipay\Common\Message\NotificationInterface;

class ServerNotifyRequest extends AbstractRequest implements NotificationInterface
{
    protected $data;

    public function getTransactionReference()
    {
        $data = explode('/', $this->getDataItem('resourcePath'));

        return end($data);
    }

    public function getTransactionStatus()
    {
        return null;
    }

    public function getMessage()
    {
        return null;
    }

    protected function getDataItem($name)
    {
        $this->getData();

        return isset($this->data[$name]) ? $this->data[$name] : '';
    }

    public function getData()
    {
        if (!isset($this->data)) {
            $this->data = $this->httpRequest->query->all();
        }

        return $this->data;
    }
}
