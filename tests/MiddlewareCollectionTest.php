<?php

declare(strict_types=1);

namespace PJ\Middleware\Tests;

use PHPUnit\Framework\TestCase;
use PJ\Middleware\MiddlewareCollection;
use RuntimeException;

class MiddlewareCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function itThrowsRuntimeExceptionWhenRetrievingFromEmptyCollection()
    {
        $this->expectException(RuntimeException::class);
        (new MiddlewareCollection())->getFirstMiddleware();
    }
}