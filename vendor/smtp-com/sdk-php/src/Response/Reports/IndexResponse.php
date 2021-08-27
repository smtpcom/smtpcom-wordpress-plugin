<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Reports;

use SmtpSdk\Model\OnDemandReport;
use SmtpSdk\Model\PeriodicReport;

/**
 * Class IndexResponse
 * @package SmtpSdk\Response\Reports
 */
class IndexResponse
{
    /**
     * @var PeriodicReport[]
     */
    private $periodic = [];

    /**
     * @var OnDemandReport[]
     */
    private $onDemand = [];

    private function __construct()
    {
    }

    /**
     * @param $data
     * @return static
     */
    public static function create($data): self
    {
        $response = new self();
        if (!empty($data['periodic'])) {
            foreach ($data['periodic'] as $periodic) {
                $response->periodic[] = new PeriodicReport($periodic);
            }
        }

        if (!empty($data['ondemand'])) {
            foreach ($data['ondemand'] as $ondemand) {
                $response->onDemand[] = new OnDemandReport($ondemand);
            }
        }

        return $response;
    }

    /**
     * Returns periodic reports
     * @return PeriodicReport[]
     */
    public function getPeriodic(): array
    {
        return $this->periodic;
    }

    /**
     * Returns on demand reports
     * @return OnDemandReport[]
     */
    public function getOnDemand(): array
    {
        return $this->onDemand;
    }
}
