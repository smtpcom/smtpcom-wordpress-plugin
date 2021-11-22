<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Callbacks\Logs;

use SmtpSdk\Model\CallbackLog;
use SmtpSdk\Response\Base;

class IndexResponse extends Base
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * Returns array of callback log objects
     * @return CallbackLog[]
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
            foreach ($data['items'] as $log) {
                $response->items[] = new CallbackLog($log);
            }
        }

        return $response;
    }
}
