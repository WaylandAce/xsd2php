<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Tests\Converter\JMS;

use GoetasWebservices\XML\XSDReader\Exception\IOException;
use GoetasWebservices\XML\XSDReader\SchemaReader;
use GoetasWebservices\Xsd\XsdToPhp\Jms\YamlConverter;
use GoetasWebservices\Xsd\XsdToPhp\Naming\ShortNamingStrategy;
use PHPUnit\Framework\TestCase;

abstract class Xsd2JmsBase extends TestCase
{
    protected YamlConverter $converter;

    protected SchemaReader $reader;

    public function setUp(): void
    {
        $this->converter = new YamlConverter(new ShortNamingStrategy());
        $this->converter->addNamespace('http://www.example.com', 'Example');

        $this->reader = new SchemaReader();
    }

    /**
     * @throws IOException
     * @throws \Exception
     */
    protected function getClasses(string $xml): array
    {
        $schema = $this->reader->readString($xml);

        return $this->converter->convert([$schema]);
    }

    public static function getBaseTypeConversions(): array
    {
        return [
            ['xs:dateTime', 'DateTime', 'GoetasWebservices\\Xsd\\XsdToPhp\\XMLSchema\\DateTime'],
            ['xs:date', 'DateTime', 'GoetasWebservices\\Xsd\\XsdToPhp\\XMLSchema\\Date'],
        ];
    }

    public static function getPrimitiveTypeConversions(): array
    {
        return [
            ['xs:string', 'string'],
            ['xs:decimal', 'float'],
            ['xs:int', 'int'],
            ['xs:integer', 'int'],
        ];
    }
}
