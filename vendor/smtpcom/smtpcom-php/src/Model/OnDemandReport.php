<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

/**
 * Class OnDemandReport
 * @package SmtpSdk\Model
 */
class OnDemandReport
{
    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $time_req;

    /**
     * @var string
     */
    private $progress;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $report_id;

    /**
     * OnDemandReport constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->status = $data['status'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->url = $data['url'] ?? '';
        $this->time_req = !empty($data['time_req']) ? strtotime($data['time_req']) : 0;
        $this->progress = $data['progress'] ?? '';
        $this->channel = $data['channel'] ?? '';
        $this->report_id = $data['report_id'] ?? '';
    }

    /**
     * Returns current status of a given on-demand report
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Returns human readable name of an on-demand report (auto-generated)
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the unique URL from which to download an on-demand report
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returns time when a given on-demand report has been
     * @return int
     */
    public function getTimeReq(): int
    {
        return $this->time_req;
    }

    /**
     * Returns percentage of completion for an on-demand report
     * @return string
     */
    public function getProgress(): string
    {
        return $this->progress;
    }

    /**
     * Returns name of the channel for which a given report has been defined
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * Returns unique report ID
     * @return string
     */
    public function getReportId(): string
    {
        return $this->report_id;
    }
}
