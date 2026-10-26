<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Alerts;

use SmtpSdk\Model\Alert;
use SmtpSdk\Response\Base;

class IndexResponse extends Base
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Returns array of alert objects
     * @return Alert[]
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
            foreach ($data['items'] as $alert) {
                $response->items[] = new Alert($alert);
            }
        }

        return $response;
    }
}
