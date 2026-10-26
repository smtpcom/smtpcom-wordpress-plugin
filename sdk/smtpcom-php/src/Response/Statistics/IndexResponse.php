<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Statistics;

use SmtpSdk\Model\Statistics;
use SmtpSdk\Response\Base;

class IndexResponse extends Base
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

    /**
     * @param array $data
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
