<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Account;

use SmtpSdk\Response\Base;

class UpdateResponse extends Base
{
    /**
     * @var string
     */
    private $status = '';

    /**
     * Returns account update status
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function create($data)
    {
        $response = new self();
        $response->status = $data['account'] ?? '';

        return $response;
    }
}
