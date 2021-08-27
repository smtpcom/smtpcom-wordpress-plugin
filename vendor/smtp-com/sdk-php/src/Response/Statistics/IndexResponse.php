<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Statistics;

use SmtpSdk\Model\Statistics;

class IndexResponse
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Returns array of statistics objects
     * @return Statistics[]
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
     * @return self
     */
    public static function create($data): self
    {
        $response = new self();
        if (!empty($data['items'])) {
            foreach ($data['items'] as $statistics) {
                $response->items[] = new Statistics($statistics);
            }
        }

        return $response;
    }
}
