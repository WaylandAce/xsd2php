<?php

namespace GoetasWebservices\Xsd\XsdToPhp\Php\Structure;

class PHPProperty extends PHPArg
{
    protected string $visibility = 'protected';

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }
}
