<?php

namespace Omnipay\Oppwa\Message;

use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    public function testPurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseSuccess.txt');
        $response = new Response($this->getMockRequest(), json_decode($httpResponse->getBody(), true), $httpResponse->getStatusCode());
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('8a8294495bd8df2e015bdcff493b390b', $response->getTransactionReference());
        $this->assertEquals($response->getCode(), 200);
    }
    public function testPurchaseFailure()
    {
        $httpResponse = $this->getMockHttpResponse('PurchaseFailure.txt');
        $response = new Response($this->getMockRequest(), json_decode($httpResponse->getBody(), true), $httpResponse->getStatusCode());
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertEquals($response->getCode(), 403);
    }
}