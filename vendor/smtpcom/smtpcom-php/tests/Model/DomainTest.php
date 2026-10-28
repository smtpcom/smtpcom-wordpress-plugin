<?php

namespace SmtpSdk\Tests\Model;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SmtpSdk\Model\Domain;

/**
 * Class DomainTest
 */
class DomainTest extends TestCase
{
    /**
     * @param array $data
     */
    #[DataProvider('domainProvider')]
    public function testDomain(array $data)
    {
        $domainObject = new Domain($data);

        $this->assertEquals($data, [
            'domain_name' => $domainObject->getDomainName(),
            'enabled' => $domainObject->isEnabled()
        ]);
    }

    /**
     * @return array
     */
    public static function domainProvider()
    {
        $json = <<<'JSON'
        {
            "status": "success",
            "data": {
                "domain_name": "test.com",
                "enabled": true
            }
        }
JSON;
        return [[json_decode($json, true)['data']]];
    }
}
