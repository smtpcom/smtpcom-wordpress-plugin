<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Domains;

use SmtpSdk\Model\Domain;
use SmtpSdk\Response\Base;

class IndexResponse extends Base
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Returns array of domain objects
     * @return Domain[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $data
     * @return IndexResponse
     */
    public static function create($data)
    {
        $response = new self();
        if (!empty($data['items'])) {
            foreach ($data['items'] as $domain) {
                $response->items[] = new Domain($domain);
            }
        }

        return $response;
    }
}
