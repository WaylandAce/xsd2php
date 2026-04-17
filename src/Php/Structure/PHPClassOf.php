<?php

namespace GoetasWebservices\Xsd\XsdToPhp\Php\Structure;

class PHPClassOf extends PHPClass
{
    protected PHPArg $arg;

    public function __construct(PHPArg $arg)
    {
        $this->arg = $arg;

        parent::__construct('array');
    }

    public function __toString(): string
    {
        return 'array of ' . $this->arg->getType();
    }

    public function getArg(): PHPArg
    {
        return $this->arg;
    }
}
