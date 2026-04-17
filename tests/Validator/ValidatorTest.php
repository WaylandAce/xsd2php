<?php

namespace GoetasWebservices\Xsd\XsdToPhp\Tests\Validator;

use Composer\Autoload\ClassLoader;
use GoetasWebservices\Xsd\XsdToPhp\Tests\Validator\ota\php\TestNotNullType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorTest extends TestCase
{
    protected ValidatorInterface $validator;

    public function setUp(): void
    {
        $loader = new ClassLoader();
        $loader->addPsr4('GoetasWebservices\\Xsd\\XsdToPhp\\Tests\\Validator\\ota\\php\\', __DIR__ . '/ota/php');
        $loader->register();

        $builder = Validation::createValidatorBuilder();

        foreach (glob(__DIR__ . '/ota/validator/*.yml') as $file) {
            $builder->addYamlMapping($file);
        }

        $this->validator = $builder->getValidator();
    }

    public function testNotNullViolations()
    {
        $object = new TestNotNullType();
        $violations = $this->validator->validate($object);

        $this->assertEquals(1, count($violations));

        $object->setValue('My value');
        $violations = $this->validator->validate($object);

        $this->assertEquals(0, count($violations));
    }
}
