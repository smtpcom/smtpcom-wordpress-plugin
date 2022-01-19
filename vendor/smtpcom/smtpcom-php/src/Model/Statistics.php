<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

class Statistics
{
    /**
     * @var int
     */
    private $accepted;

    /**
     * @var int
     */
    private $complained;

    /**
     * @var int
     */
    private $delivered;

    /**
     * @var int
     */
    private $clicked;

    /**
     * @var int
     */
    private $opened;

    /**
     * @var int
     */
    private $failed;

    /**
     * @var int
     */
    private $unsubscribed;

    /**
     * @var int
     */
    private $queued;

    /**
     * Statistics constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->accepted = intval($data['accepted'] ?? 0);
        $this->complained = intval($data['complained'] ?? 0);
        $this->delivered = intval($data['delivered'] ?? 0);
        $this->clicked = intval($data['clicked'] ?? 0);
        $this->opened = intval($data['opened'] ?? 0);
        $this->failed = intval($data['failed'] ?? 0);
        $this->unsubscribed = intval($data['unsubscribed'] ?? 0);
        $this->queued = intval($data['queued'] ?? 0);
    }

    /**
     * @return int
     */
    public function getAccepted(): int
    {
        return $this->accepted;
    }

    /**
     * @return int
     */
    public function getComplained(): int
    {
        return $this->complained;
    }

    /**
     * @return int
     */
    public function getDelivered(): int
    {
        return $this->delivered;
    }

    /**
     * @return int
     */
    public function getClicked(): int
    {
        return $this->clicked;
    }

    /**
     * @return int
     */
    public function getOpened(): int
    {
        return $this->opened;
    }

    /**
     * @return int
     */
    public function getFailed(): int
    {
        return $this->failed;
    }

    /**
     * @return int
     */
    public function getUnsubscribed(): int
    {
        return $this->unsubscribed;
    }

    /**
     * @return int
     */
    public function getQueued(): int
    {
        return $this->queued;
    }
}
