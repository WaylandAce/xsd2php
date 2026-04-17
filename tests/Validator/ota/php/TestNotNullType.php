<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Tests\Validator\ota\php;

/**
 * Class representing TestNotNull.
 *
 * XSD Type: testNotNull
 */
class TestNotNullType
{
    private ?string $value = null;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
