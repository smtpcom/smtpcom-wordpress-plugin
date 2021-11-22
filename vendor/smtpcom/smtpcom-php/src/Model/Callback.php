<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

class Callback
{
    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $event;

    /**
     * @var string
     */
    private $medium;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $aws_data;

    /**
     * Callback constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->channel = $data['channel'] ?? '';
        $this->event = $data['event'] ?? '';
        $this->medium = $data['medium'] ?? '';
        $this->address = $data['address'] ?? '';
        $this->aws_data = $data['aws_data'] ?? '';
    }

    /**
     * Returns name of the channel for which the callback has been created
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * Returns event for which the callback has been created
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * Returns medium by which the callback data is sent
     * @return string
     */
    public function getMedium(): string
    {
        return $this->medium;
    }

    /**
     * Returns address to which the callback data is sent
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Returns amazon SQS settings
     * @return string
     */
    public function getAwsData(): string
    {
        return $this->aws_data;
    }
}
