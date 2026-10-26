<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Channels;

use SmtpSdk\Model\Channel;
use SmtpSdk\Response\Base;

class IndexResponse extends Base
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Returns array of channel objects
     * @return Channel[]
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
            foreach ($data['items'] as $message) {
                $response->items[] = new Channel($message);
            }
        }

        return $response;
    }
}
