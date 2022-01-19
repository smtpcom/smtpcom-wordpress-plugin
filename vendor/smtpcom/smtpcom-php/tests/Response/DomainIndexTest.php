<?php

namespace SmtpSdk\Tests\Response;

use PHPUnit\Framework\TestCase;
use SmtpSdk\Response\Domains\IndexResponse;
use SmtpSdk\Model\Domain;

/**
 * Class DomainIndexTest
 */
class DomainIndexTest extends TestCase
{
    /**
     * @dataProvider domainProvider
     *
     * @param array $data
     */
    public function testIndex(array $data)
    {
        $responseObject = IndexResponse::create($data);

        foreach ($responseObject->getItems() as $item) {
            $this->assertInstanceOf(Domain::class, $item);
        }
        $this->assertCount(2, $responseObject->getItems());
    }

    /**
     * @return array
     */
    public function domainProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "items": [
                    {
                        "domain_name": "test.com",
                        "enabled": "" 
                    },
                    {
                        "domain_name": "test2.com",
                        "enabled": true
                    }
                ] 
            }
        }
JSON;

        return [[json_decode($json, true)['data']]];
    }
}
