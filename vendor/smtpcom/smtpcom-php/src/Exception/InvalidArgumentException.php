<?php

namespace SmtpSdk\Exception;

use Assert\AssertionFailedException;
use SmtpSdk\SmtpSdkException;

class InvalidArgumentException extends SmtpSdkException implements AssertionFailedException
{
    /**
     * @var string|null
     */
    private $propertyPath;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array
     */
    private $constraints;

    public function __construct($message, $code, ?string $propertyPath = null, $value = null, array $constraints = [])
    {
        parent::__construct($message, $code);

        $this->propertyPath = $propertyPath;
        $this->value = $value;
        $this->constraints = $constraints;
    }

    /**
     * User controlled way to define a sub-property causing
     * the failure of a currently asserted objects.
     *
     * Useful to transport information about the nature of the error
     * back to higher layers.
     *
     * @return string|null
     */
    #[\Override]
    public function getPropertyPath()
    {
        return $this->propertyPath;
    }

    /**
     * Get the value that caused the assertion to fail.
     *
     * @return mixed
     */
    #[\Override]
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the constraints that applied to the failed assertion.
     */
    #[\Override]
    public function getConstraints(): array
    {
        return $this->constraints;
    }
}
