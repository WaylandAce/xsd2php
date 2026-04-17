<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\PathGenerator;

abstract class Psr4PathGenerator
{
    protected array $namespaces = [];

    public function __construct(array $targets = [])
    {
        $this->setTargets($targets);
    }

    public function setTargets(array $namespaces): void
    {
        $this->namespaces = $namespaces;

        foreach ($this->namespaces as $dir) {
            if (! is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
        }
    }
}
