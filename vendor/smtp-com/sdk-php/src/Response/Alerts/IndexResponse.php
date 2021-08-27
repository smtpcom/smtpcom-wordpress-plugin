<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Alerts;

use SmtpSdk\Model\Alert;

class IndexResponse
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
            foreach ($data['items'] as $alert) {
                $response->items[] = new Alert($alert);
            }
        }

        return $response;
    }
}
