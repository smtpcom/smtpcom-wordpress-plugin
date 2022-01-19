<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Message;

use SmtpSdk\Model\Message;
use SmtpSdk\Response\Base;

/**
 * Class IndexResponse
 * @package SmtpSdk\Response\Message
 */
class IndexResponse extends Base
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Returns array of message objects
     * @return Message[]
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
                $response->items[] = new Message($message);
            }
        }

        return $response;
    }
}
