<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Construction\UnserializeObjectConstructor;
use C95\Infrastructure\JMS\Serializer\Construction\DoctrineObjectConstructor;

/**
 * @todo Add configuration
 */
class Bootstrap {

    /**
     * @var Pimple
     */
    private $container;

    private $configuration;

    public function __construct($configuration = null) {
        $this->container = new Pimple();
        $this->configuration = $configuration;
    }

    /**
     * @return Pimple
     */
    public function run() {
        $this->initDocumentManager();
        $this->initSerializer();

        return $this->container;
    }

    protected function initDocumentManager() {
        $this->container['odm'] = $this->container->share(function($container) {
            AnnotationDriver::registerAnnotationClasses();

            $config = new Configuration();
            $config->setProxyDir(__DIR__ . '/../app/cache/proxies');
            $config->setProxyNamespace('Proxies');
            $config->setHydratorDir(__DIR__ . '/../app/cache/hydrators');
            $config->setHydratorNamespace('Hydrators');

            $driver = new YamlDriver(array(__DIR__ . '/../src/C95/Domain/Config/Mapping'), '.yml');
            $config->setMetadataDriverImpl($driver);

            return DocumentManager::create(new Connection(), $config);
        });
    }

    protected function initSerializer() {
        $this->container['serializer'] = $this->container->share(function($container) {
            $serializer = SerializerBuilder::create()
                ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
                ->setObjectConstructor(new DoctrineObjectConstructor($container['odm'], new UnserializeObjectConstructor()))
                ->addMetadataDir(__DIR__ . '/../src/C95/Domain/Config/TransferObject', 'C95\Domain')
                ->build();
            return $serializer;
        });
    }

}