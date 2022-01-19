<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

/**
 * Class ApiKey
 * @package SmtpSdk\Model
 */
class ApiKey
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
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $key;

    /**
     * @var int
     */
    private $created_date;

    /**
     * ApiKey constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'] ?? '';
        $this->status = $data['status'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->key = $data['key'] ?? '';
        $this->created_date = intval($data['created_date'] ?? 0);
    }

    /**
     * Returns name of the API key
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns current status of the API key
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Returns description for API key
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Returns the actual API key value
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Returns timestamp of when the API key was first created.
     * @return integer
     */
    public function getCreatedDate(): int
    {
        return $this->created_date;
    }
}
