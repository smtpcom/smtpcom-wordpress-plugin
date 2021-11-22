<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

/**
 * Class Channel
 * @package SmtpSdk\Model
 */
class Channel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $status;

    /**
     * @var integer
     */
    private $quota;

    /**
     * @var string
     */
    private $label;

    /**
     * @var integer
     */
    private $usage;

    /**
     * @var integer
     */
    private $date_created;

    /**
     * @var string
     */
    private $smtp_username;

    /**
     * Channel constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->status = $data['status'] ?? '';
        $this->quota = intval($data['quota'] ?? 0);
        $this->label = $data['label'] ?? '';
        $this->usage = intval($data['usage'] ?? 0);
        $this->date_created = !empty($data['date_created']) ? strtotime($data['date_created']) : 0;
        $this->smtp_username = $data['smtp_username'] ?? '';
    }

    /**
     * Returns current status of the channel
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Returns name of the channel
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns quota for the channel
     * @return int
     */
    public function getQuota(): int
    {
        return $this->quota;
    }

    /**
     * Returns label for the channel
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Returns current usage for the channel
     * @return int
     */
    public function getUsage(): int
    {
        return $this->usage;
    }

    /**
     * Returns timestamp for when the channel was originally created
     * @return int
     */
    public function getDateCreated(): int
    {
        return $this->date_created;
    }

    /**
     * Returns username for the channel
     * @return string
     */
    public function getSmtpUsername(): string
    {
        return $this->smtp_username;
    }
}
