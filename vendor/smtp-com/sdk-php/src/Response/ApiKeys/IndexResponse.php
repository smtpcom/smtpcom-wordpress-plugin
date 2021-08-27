<?php

declare(strict_types=1);

namespace SmtpSdk\Response\ApiKeys;

use SmtpSdk\Model\ApiKey;

class IndexResponse
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

    private function __construct()
    {
    }

    /**
     * @param $data array
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
