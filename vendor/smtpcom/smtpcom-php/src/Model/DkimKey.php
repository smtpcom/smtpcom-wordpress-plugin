<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

class DkimKey
{
    /**
     * @var string
     */
    private $domain_name;

    /**
     * @var string
     */
    private $selector;

    /**
     * @var string
     */
    private $private_key;

    /**
     * @var bool
     */
    private $is_valid;

    /**
     * DkimKey constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->domain_name = $data['domain_name'] ?? '';
        $this->selector = $data['selector'] ?? '';
        $this->private_key = $data['private_key'] ?? '';
        $this->is_valid = !empty($data['is_valid']);
    }

    /**
     * Returns registered domain name
     * @return string
     */
    public function getDomainName(): string
    {
        return $this->domain_name;
    }

    /**
     * Returns name of the DKIM selector for the domain
     * @return string
     */
    public function getSelector(): string
    {
        return $this->selector;
    }

    /**
     * Returns private key of the DKIM record
     * @return string
     */
    public function getPrivateKey(): string
    {
        return $this->private_key;
    }

    /**
     * Returns flag indicating whether the DKIM is valid
     * @return bool
     */
    public function isIsValid(): bool
    {
        return $this->is_valid;
    }
}
