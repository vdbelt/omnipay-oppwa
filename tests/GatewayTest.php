<?php

namespace Omnipay\Oppwa;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    protected $gateway;

    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase(array('amount' => '10.00', 'currency' => 'USD'));
        $this->assertInstanceOf('Omnipay\Oppwa\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('USD', $request->getCurrency());
    }

    public function testCapture()
    {
        $request = $this->gateway->capture(array('amount' => '10.00', 'currency' => 'USD'));
        $this->assertInstanceOf('Omnipay\Oppwa\Message\CaptureRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('USD', $request->getCurrency());
    }

    public function testAuthorize()
    {
        $request = $this->gateway->authorize(array('amount' => '10.00', 'currency' => 'USD'));
        $this->assertInstanceOf('\Omnipay\Oppwa\Message\AuthorizeRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
        $this->assertSame('USD', $request->getCurrency());
    }

    public function testVoid()
    {
        $request = $this->gateway->void(array('transactionReference' => '123'));
        $this->assertInstanceOf('\Omnipay\Oppwa\Message\VoidRequest', $request);
        $this->assertSame('123', $request->getTransactionReference());
    }

    public function testRefund()
    {
        $request = $this->gateway->refund(array('transactionReference' => '123'));
        $this->assertInstanceOf('\Omnipay\Oppwa\Message\RefundRequest', $request);
        $this->assertSame('123', $request->getTransactionReference());
    }
}
