<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Callbacks;

use SmtpSdk\Model\Callback;

class IndexResponse
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Returns array of callback objects
     * @return Callback[]
     */
    public function getItems()
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
            foreach ($data['items'] as $callback) {
                $response->items[] = new Callback($callback);
            }
        }

        return $response;
    }
}
