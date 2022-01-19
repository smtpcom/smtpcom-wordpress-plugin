<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

/**
 * Class Message
 * @package SmtpSdk\Response\Message
 */
class Message
{
    /**
     * @var string
     */
    private $msg_id;

    /**
     * @var int
     */
    private $msg_time;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var array
     */
    private $smtp_vars;

    /**
     * @var array
     */
    private $msg_data;

    /**
     * @var array
     */
    private $details;

    /**
     * Message constructor.
     */
    public function __construct(array $message)
    {
        $this->msg_id = $message['msg_id'] ?? '';
        $this->msg_time = !empty($message['msg_time']) ? strtotime($message['msg_time']) : 0;
        $this->channel = $message['channel'] ?? '';
        $this->smtp_vars = $message['smtp_vars'] ?? [];
        $this->msg_data = $message['msg_data'] ?? [];
        $this->details = $message['details'] ?? [];
    }

    /**
     * Returns unique message ID
     * @return string
     */
    public function getMsgId(): string
    {
        return $this->msg_id;
    }

    /**
     * Returns timestamp at which the message was sent
     * @return int
     */
    public function getMsgTime(): int
    {
        return $this->msg_time;
    }

    /**
     * Returns name of the channel on which the message was sent
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * Returns custom parameters and their value echoed back from X-SMTPAPI header's unique_args parameter
     * @return array
     */
    public function getSmtpVars(): array
    {
        return $this->smtp_vars;
    }

    /**
     * Returns recipient, sender and subject of the message
     * @return array
     */
    public function getMsgData(): array
    {
        return $this->msg_data;
    }

    /**
     * Returns detailed data
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}
