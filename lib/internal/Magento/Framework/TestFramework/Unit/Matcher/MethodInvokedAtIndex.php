<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Framework\TestFramework\Unit\Matcher;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\MockObject\Invocation;

/**
 * Class MethodInvokedAtIndex
 * Matches invocations per 'method' at 'position'
 * Example:
 * $mock->expects(new MethodInvokedAtIndex(0))->method('getMethod')->willReturn(1);
 * $mock->expects(new MethodInvokedAtIndex(1))->method('getMethod')->willReturn(2);
 *
 * $mock->getMethod(); // returns 1
 * $mock->getMethod(); // returns 2
 *
 * @package Magento\TestFramework\Matcher
 */
class MethodInvokedAtIndex implements \PHPUnit\Framework\MockObject\Matcher\Invocation
{
    /**
     * @var array
     */
    protected $indexes = [];

    /**PHPUnit_Framework_MockObject_Matcher_InvokedAtIndex
     * @var int
     */
    private $currentIndex = -1;

    /**
     * @var int
     */
    private $sequenceIndex;

    /**
     * @param int $sequenceIndex
     */
    public function __construct($sequenceIndex)
    {
        $this->sequenceIndex = $sequenceIndex;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return 'invoked at sequence index ' . $this->sequenceIndex;
    }

    /**
     * @param  \PHPUnit\Framework\MockObject\Invocation $invocation
     * @return boolean
     */
    public function matches(Invocation $invocation): bool
    {
        /** @noinspection PhpUndefinedFieldInspection */
        if (!isset($this->indexes[$invocation->getMethodName()])) {
            /** @noinspection PhpUndefinedFieldInspection */
            $this->indexes[$invocation->getMethodName()] = 0;
        } else {
            /** @noinspection PhpUndefinedFieldInspection */
            $this->indexes[$invocation->getMethodName()]++;
        }
        $this->currentIndex++;

        /** @noinspection PhpUndefinedFieldInspection */
        return $this->indexes[$invocation->getMethodName()] === $this->sequenceIndex;
    }

    /**
     * Verifies that the current expectation is valid. If everything is OK the
     * code should just return, if not it must throw an exception.
     *
     * @throws ExpectationFailedException
     */
    public function verify(): void
    {
        if ($this->currentIndex < $this->sequenceIndex) {
            throw new ExpectationFailedException(
                \sprintf(
                    'The expected invocation at index %s was never reached.',
                    $this->sequenceIndex
                )
            );
        }
    }

    /**
     * @param Invocation $invocation Object containing information on a mocked or stubbed method which was invoked
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function invoked(Invocation $invocation)
    {
    }
}
