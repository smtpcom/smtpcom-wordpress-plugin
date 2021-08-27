<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Account;

class UpdateResponse
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

    private function __construct()
    {
    }

    /**
     * @param $data array
     * @return self
     */
    public static function create($data)
    {
        $response = new self();
        $response->status = $data['account'] ?? '';

        return $response;
    }
}
