<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Tests\PathGenerator;

use GoetasWebservices\Xsd\XsdToPhp\Jms\PathGenerator\Psr4PathGenerator;
use GoetasWebservices\Xsd\XsdToPhp\PathGenerator\PathGeneratorException;
use PHPUnit\Framework\TestCase;

class JMSPathGeneratorTest extends TestCase
{
    protected string $tmpdir;

    public function setUp(): void
    {
        $tmp = sys_get_temp_dir();

        if (is_writable('/dev/shm')) {
            $tmp = '/dev/shm';
        }

        $this->tmpdir = "$tmp/PathGeneratorTest";
        if (! is_dir($this->tmpdir)) {
            mkdir($this->tmpdir);
        }
    }

    public function testNoNs(): void
    {
        $this->expectException('GoetasWebservices\Xsd\XsdToPhp\PathGenerator\PathGeneratorException');
        $generator = new Psr4PathGenerator([
            'myns2\\' => $this->tmpdir,
        ]);
        $generator->getPath([
            'myns\Bar' => true,
        ]);
    }

    /**
     * @throws PathGeneratorException
     */
    public function testWriterLong(): void
    {
        $generator = new Psr4PathGenerator([
            'myns\\' => $this->tmpdir,
        ]);

        $path = $generator->getPath([
            'myns\foo\Bar' => true,
        ]);
        $this->assertEquals($path, $this->tmpdir . '/foo.Bar.yml');
    }

    /**
     * @throws PathGeneratorException
     */
    public function testWriter(): void
    {
        $generator = new Psr4PathGenerator([
            'myns\\' => $this->tmpdir,
        ]);

        $path = $generator->getPath([
            'myns\Bar' => true,
        ]);

        $this->assertEquals($path, $this->tmpdir . '/Bar.yml');
    }
}
