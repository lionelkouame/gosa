<?php

declare(strict_types=1);

namespace Gosa\Tests\Behat\Context;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

final class SmokeContext implements Context
{
    private string $environment = '';

    /**
     * @Given the application is running
     */
    public function theApplicationIsRunning(): void
    {
        $this->environment = $_SERVER['APP_ENV'] ?? \getenv('APP_ENV') ?: 'test';
        Assert::assertNotEmpty($this->environment);
    }

    /**
     * @Then the environment should be :env
     */
    public function theEnvironmentShouldBe(string $env): void
    {
        Assert::assertSame($env, $this->environment);
    }

    /**
     * @Then the application name should be :name
     */
    public function theApplicationNameShouldBe(string $name): void
    {
        Assert::assertSame('GOSA', $name);
    }
}
