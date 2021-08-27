<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Message;

class CreateResponse
{
    /**
     * @var string
     */
    private $message = [];

    /**
     * Returns array of message objects
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    private function __construct()
    {
    }

    /**
     * @param $data array
     * @return CreateResponse
     */
    public static function create($data)
    {
        $response = new self();
        $response->message = $data['message'];
        return $response;
    }
}
