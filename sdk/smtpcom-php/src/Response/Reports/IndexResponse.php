<?php

declare(strict_types=1);

namespace SmtpSdk\Response\Reports;

use SmtpSdk\Model\OnDemandReport;
use SmtpSdk\Model\PeriodicReport;
use SmtpSdk\Response\Base;

/**
 * Class IndexResponse
 * @package SmtpSdk\Response\Reports
 */
class IndexResponse extends Base
{
    /**
     * @var PeriodicReport[]
     */
    private $periodic = [];

    /**
     * @var OnDemandReport[]
     */
    private $onDemand = [];

    /**
     * @param array $data
     * @return self
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
