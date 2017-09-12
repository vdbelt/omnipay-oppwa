<?php

namespace Omnipay\Oppwa\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

class Response extends AbstractResponse implements RedirectResponseInterface
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    public function isSuccessful()
    {
        list( $first, $second, ) = explode('.', (string) $this->data['result']['code']);

        return ! $this->isRedirect() && ! $this->isPending()
            && $this->getCode() < 400 && $first == '000' && $second < '200';
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

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        $list = array();

        foreach ($this->data['redirect']['parameters'] as $pair) {
            $list[$pair['name']] = $pair['value'];
        }

        return  $list;
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
