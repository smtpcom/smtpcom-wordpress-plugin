<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

class Alert
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var float
     */
    private $threshold;

    /**
     * @var string
     */
    private $alert_id;

    /**
     * Alert constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->type = $data['type'] ?? '';
        $this->threshold = floatval($data['threshold'] ?? 0);
        $this->alert_id = $data['alert_id'] ?? '';
    }

    /**
     * Returns type of alert
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Returns a number which represents a percentage of an account’s monthly quota
     * @return float
     */
    public function getThreshold(): float
    {
        return $this->threshold;
    }

    /**
     * Returns alert ID
     * @return string
     */
    public function getAlertId(): string
    {
        return $this->alert_id;
    }
}
