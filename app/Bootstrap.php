<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

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
            $config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/../src/C95/Domain'));

            return DocumentManager::create(new Connection(), $config);
        });
    }



}