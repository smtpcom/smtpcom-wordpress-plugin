<?php

namespace SmtpSdk\Model;

class Domain
{
    /**
     * @var string
     */
    private $domain_name;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * Domain constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->domain_name = $data['domain_name'] ?? '';
        $this->enabled = !empty($data['enabled']);
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
     * Return flag indicating whether the domain is enabled for the given account
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }
}
