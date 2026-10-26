<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

class CommonReport
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
     * CommonReport constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->frequency = $data['frequency'] ?? '';
        $this->report_id = $data['report_id'] ?? '';
        $this->events = $data['events'] ?? '';
        $this->channel = $data['channel'] ?? '';
        $this->report_time = intval($data['report_time'] ?? 0);
        $this->status = $data['status'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->url = $data['url'] ?? '';
        $this->time_req = !empty($data['time_req']) ? strtotime($data['time_req']) : 0;
        $this->progress = $data['progress'] ?? '';
    }

    /**
     * Returns report frequency
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
     * Returns preset of events returned in a report
     * @return string
     */
    public function getEvents(): string
    {
        return $this->events;
    }

    /**
     * Returns name of channel (sender)
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
     * Returns the unique URL from which to download an on-demand report from
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returns time when a given on-demand report has been requested
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
}
