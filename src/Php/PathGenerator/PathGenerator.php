<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Php\PathGenerator;

use Laminas\Code\Generator\ClassGenerator;

interface PathGenerator
{
    public function getPath(ClassGenerator $php): string;
}
