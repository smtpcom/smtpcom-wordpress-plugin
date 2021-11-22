<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

/**
 * Class Account
 * @package SmtpSdk\Model
 */
class Account
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $company_name;

    /**
     * @var array
     */
    private $address;

    /**
     * @var int
     */
    private $usage;

    /**
     * @var int
     */
    private $date_created;

    /**
     * Account constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->status = $data['status'] ?? '';
        $this->first_name = $data['first_name'] ?? '';
        $this->last_name = $data['last_name'] ?? '';
        $this->phone = $data['phone'] ?? '';
        $this->website = $data['website'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->company_name = $data['company_name'] ?? '';
        $this->address = $data['address'] ?? [];
        $this->usage = intval($data['usage'] ?? 0);
        $this->date_created = !empty($data['date_created']) ? strtotime($data['date_created']) : 0;
    }

    /**
     * Returns status of the account
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Returns first name of account owner
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * Returns last name of account owner
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * Returns phone number of account owner
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Returns website of account owner
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * Returns email address of account owner
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Returns account owner’s company name
     * @return string
     */
    public function getCompanyName(): string
    {
        return $this->company_name;
    }

    /**
     * Returns full address of account owner
     * @return array
     */
    public function getAddress(): array
    {
        return $this->address;
    }

    /**
     * Returns account's usage
     * @return int
     */
    public function getUsage(): int
    {
        return $this->usage;
    }

    /**
     * Returns account's creation time
     * @return int
     */
    public function getDateCreated(): int
    {
        return $this->date_created;
    }
}
