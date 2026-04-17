<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Php\Structure;

class PHPArg
{
    protected ?string $doc = null;

    protected ?PHPClass $type = null;

    protected string $name;

    protected bool $nullable = false;

    protected mixed $default = null;

    public function __construct(string $name, ?PHPClass $type = null)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getDoc(): ?string
    {
        return $this->doc;
    }

    public function setDoc(string $doc): static
    {
        $this->doc = $doc;

        return $this;
    }

    public function getType(): ?PHPClass
    {
        return $this->type;
    }

    public function setType(PHPClass $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNullable(): bool
    {
        return $this->nullable;
    }

    public function setNullable(bool $nullable): static
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function getDefault(): mixed
    {
        return $this->default;
    }

    public function setDefault(mixed $default): static
    {
        $this->default = $default;

        return $this;
    }
}
