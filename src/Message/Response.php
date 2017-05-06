<?php

namespace Omnipay\Oppwa\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    public function isSuccessful()
    {
        return ! $this->isRedirect() && ! $this->isPending() && $this->getCode() < 400;
    }

    public function isRedirect()
    {
        return isset($this->data['redirect']['url']);
    }

    public function isPending()
    {
        return isset($this->data['result']['code']) && substr($this->data['result']['code'], 0, 7) == '000.200';
    }

    public function getTransactionReference()
    {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
    }

    public function getTransactionId()
    {
        if (isset($this->data['merchantTransactionId'])) {
            return $this->data['merchantTransactionId'];
        }
    }

    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return $this->data['redirect']['url'];
        }
    }

    public function getMessage()
    {
        if (isset($this->data['result']['description'])) {
            return $this->data['result']['description'];
        }

        return null;
    }

    public function getCode()
    {
        return $this->statusCode;
    }
}
