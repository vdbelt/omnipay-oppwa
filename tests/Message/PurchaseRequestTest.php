<?php

namespace Omnipay\Oppwa\Message;

use Omnipay\Oppwa\Gateway;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '10.00',
                'currency' => 'USD',
                'integrationType' => Gateway::TYPE_SERVER_TO_SERVER,
            )
        );
    }

    public function testGetData()
    {
        $this->assertSame('DB', $this->request->getData()['paymentType']);
    }

    public function testSend()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
    }
}