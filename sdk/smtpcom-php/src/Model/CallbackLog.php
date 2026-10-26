<?php

declare(strict_types=1);

namespace SmtpSdk\Model;

class CallbackLog
{
    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $msg;

    /**
     * @var integer
     */
    private $time;

    /**
     * CallbackLog constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->code = intval($data['code'] ?? 0);
        $this->msg = $data['msg'] ?? '';
        $this->time = !empty($data['time']) ? strtotime($data['time']) : 0;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }
}
