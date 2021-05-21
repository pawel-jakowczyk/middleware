<?php

declare(strict_types=1);

namespace pj\middleware;

use IteratorAggregate;

interface MiddlewareCollectionInterface extends IteratorAggregate
{
    public function withoutCurrent(): self;
}