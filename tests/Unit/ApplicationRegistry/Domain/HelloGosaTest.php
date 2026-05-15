<?php

declare(strict_types=1);

namespace Gosa\Tests\Unit\ApplicationRegistry\Domain;

use PHPUnit\Framework\TestCase;

final class HelloGosaTest extends TestCase
{
    public function test_environment_is_ready(): void
    {
        $this->expectOutputString('Hello GOSA');

        echo 'Hello GOSA';
    }
}
