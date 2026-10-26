<?php

declare(strict_types=1);

namespace SmtpSdk\Response\ApiKeys;

use SmtpSdk\Model\ApiKey;
use SmtpSdk\Response\Base;

class IndexResponse extends Base
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Returns array of key objects
     * @return ApiKey[]
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
            foreach ($data['items'] as $apiKey) {
                $response->items[] = new ApiKey($apiKey);
            }
        }

        return $response;
    }
}
