<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

/**
 * Class PeriodicReport
 * @package SmtpSdk\Model
 */
class PeriodicReport
{
    /**
     * @var string
     */
    private $frequency;

    /**
     * @var string
     */
    private $report_id;

    /**
     * @var string
     */
    private $events;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var int
     */
    private $report_time;

    /**
     * PeriodicReport constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->frequency = $data['frequency'] ?? '';
        $this->report_id = $data['report_id'] ?? '';
        $this->events = $data['events'] ?? '';
        $this->channel = $data['channel'] ?? '';
        $this->report_time = intval($data['report_time'] ?? 0);
    }

    /**
     * Returns periodic report frequency
     * @return string
     */
    public function getFrequency(): string
    {
        return $this->frequency;
    }

    /**
     * Returns unique report ID
     * @return string
     */
    public function getReportId(): string
    {
        return $this->report_id;
    }

    /**
     * Returns preset of events returned in a periodic report
     * @return string
     */
    public function getEvents(): string
    {
        return $this->events;
    }

    /**
     * Returns name of the channel for which a report has been defined
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * Returns the hour at which the report should be sent, values range from 0 to 23
     * @return int
     */
    public function getReportTime(): int
    {
        return $this->report_time;
    }
}
