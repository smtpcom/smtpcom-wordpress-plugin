<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Message;

use SmtpSdk\Response\Base;

class CreateResponse extends Base
{
    /**
     * @var string
     */
    private $message;

    /**
     * Returns array of message objects
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param array $data
     * @return CreateResponse
     */
    public static function create($data)
    {
        $response = new self();
        $response->message = $data['message'];
        return $response;
    }
}
