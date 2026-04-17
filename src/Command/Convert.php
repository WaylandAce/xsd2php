<?php

declare(strict_types=1);

namespace GoetasWebservices\Xsd\XsdToPhp\Command;

use GoetasWebservices\XML\XSDReader\Exception\IOException;
use GoetasWebservices\XML\XSDReader\SchemaReader;
use GoetasWebservices\Xsd\XsdToPhp\AbstractConverter;
use GoetasWebservices\Xsd\XsdToPhp\Writer\Writer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Convert extends Command
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    /**
     * @see Console\Command\Command
     */
    protected function configure(): void
    {
        $this->setName('convert');
        $this->setDescription('Convert a XSD file into PHP classes and JMS serializer metadata files');
        $this->setDefinition([
            new InputArgument('config', InputArgument::REQUIRED, 'Where is located your XSD definitions'),
            new InputArgument('src', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Where is located your XSD definitions'),
        ]);
    }

    /**
     * @throws IOException
     * @throws \Exception
     * @see Console\Command\Command
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->loadConfigurations($input->getArgument('config'));
        $src = $input->getArgument('src');

        $schemas = [];
        /** @var SchemaReader $reader */
        $reader = $this->container->get('goetas_webservices.xsd2php.schema_reader');
        foreach ($src as $file) {
            $schemas[] = $reader->readFile($file);
        }
        $configs = $this->container->getParameter('goetas_webservices.xsd2php.config');

        $items = [];
        foreach (['php', 'jms', 'validation'] as $type) {
            if ($type === 'validation' && empty($configs['destinations_' . $type])) {
                continue;
            }
            /** @var AbstractConverter $converter */
            $converter = $this->container->get('goetas_webservices.xsd2php.converter.' . $type);
            $items = $converter->convert($schemas);

            /** @var Writer $writer */
            $writer = $this->container->get('goetas_webservices.xsd2php.writer.' . $type);
            $writer->write($items);
        }

        return count($items) ? 0 : 255;
    }

    /**
     * @throws \Exception
     */
    protected function loadConfigurations(string $configFile): void
    {
        $locator = new FileLocator('.');
        $yaml = new YamlFileLoader($this->container, $locator);

        $delegatingLoader = new DelegatingLoader(new LoaderResolver([$yaml]));
        $delegatingLoader->load($configFile);

        $this->container->compile();
    }
}
