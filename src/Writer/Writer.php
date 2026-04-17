<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Writer;

abstract class Writer
{
    abstract public function write(array $items);
}
