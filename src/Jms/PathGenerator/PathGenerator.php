<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Jms\PathGenerator;

interface PathGenerator
{
    public function getPath(array $yaml): string;
}
