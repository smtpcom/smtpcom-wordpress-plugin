<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Message;

use SmtpSdk\Model\Message;

/**
 * Class IndexResponse
 * @package SmtpSdk\Response\Message
 */
class IndexResponse
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
     * IndexResponse constructor.
     */
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
            foreach ($data['items'] as $message) {
                $response->items[] = new Message($message);
            }
        }

        return $response;
    }
}
