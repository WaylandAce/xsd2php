<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Tests;

use GoetasWebservices\Xsd\XsdToPhp\Jms\YamlConverter;
use GoetasWebservices\Xsd\XsdToPhp\Jms\YamlValidatorConverter;
use GoetasWebservices\Xsd\XsdToPhp\Php\PhpConverter;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Generator extends AbstractGenerator
{
    /**
     * @throws \Exception
     */
    public function generate(array $schemas): void
    {
        $this->cleanDirectories();

        $this->writeJMS($this->generateJMSFiles($schemas));
        $this->writePHP($this->generatePHPFiles($schemas));
        $this->writeValidation($this->generateValidationFiles($schemas));
    }

    /**
     * @throws \Exception
     */
    public function getData(array $schemas): array
    {
        $php = $this->generatePHPFiles($schemas);
        $jms = $this->generateJMSFiles($schemas);
        $validation = $this->generateValidationFiles($schemas);

        return [$php, $jms, $validation];
    }

    protected function generatePHPFiles(array $schemas): array
    {
        $converter = new PhpConverter($this->namingStrategy);
        $this->setNamespaces($converter);

        return $converter->convert($schemas);
    }

    /**
     * @throws \Exception
     */
    protected function generateJMSFiles(array $schemas): array
    {
        $converter = new YamlConverter($this->namingStrategy);
        $this->setNamespaces($converter);

        return $converter->convert($schemas);
    }

    /**
     * @throws \Exception
     */
    protected function generateValidationFiles(array $schemas): array
    {
        $converter = new YamlValidatorConverter($this->namingStrategy);
        $this->setNamespaces($converter);

        return $converter->convert($schemas);
    }

    public function getValidator(): RecursiveValidator|ValidatorInterface
    {
        $builder = Validation::createValidatorBuilder();

        foreach (glob($this->validationDir . '/*.yml') as $file) {
            $builder->addYamlMapping($file);
        }

        return $builder->getValidator();
    }
}
