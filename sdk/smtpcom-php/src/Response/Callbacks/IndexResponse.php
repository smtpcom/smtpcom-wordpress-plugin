<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Callbacks;

use SmtpSdk\Model\Callback;
use SmtpSdk\Response\Base;

class IndexResponse extends Base
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

    /**
     * @param array $data
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
