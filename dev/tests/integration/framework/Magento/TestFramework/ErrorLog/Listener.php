<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\TestFramework\ErrorLog;

use Magento\TestFramework\Helper;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;

class Listener implements TestListener
{
    /**
     * @var Logger|null
     */
    private $logger;

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function addError(Test $test, \Throwable $e, float $time): void
    {
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function addIncompleteTest(Test $test, \Throwable $e, float $time): void
    {
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function addRiskyTest(Test $test, \Throwable $e, float $time): void
    {
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function addSkippedTest(Test $test, \Throwable $e, float $time): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function startTestSuite(TestSuite $suite): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function endTestSuite(TestSuite $suite): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function startTest(Test $test): void
    {
        $this->logger = Helper\Bootstrap::getObjectManager()->get(Logger::class);
        $this->logger->clearMessages();
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function endTest(Test $test, float $time): void
    {
        if ($test instanceof TestCase) {
            $messages = $this->logger->getMessages();
            try {
                if ($messages) {
                    $test->assertEquals(
                        '',
                        var_export($messages, true),
                        'Errors were added to log during test execution.'
                    );
                }
            } catch (\Exception $e) {
                $test->getTestResultObject()->addError($test, $e, 0);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addWarning(Test $test, Warning $e, float $time): void
    {
    }
}
