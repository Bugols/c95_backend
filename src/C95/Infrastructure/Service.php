<?php

namespace C95\Infrastructure;

use Pimple;
use Doctrine\ODM\MongoDB\DocumentManager;

abstract class Service {

    /** @var Pimple */
    private $container;

    /** @var DocumentManager */
    private $documentManager;

    public function __construct(Pimple $container) {
        $this->container = $container;
        $this->documentManager = $container['odm'];
    }

    /** @return DocumentManager */
    public function getDocumentManager() {
        return $this->documentManager;
    }

    /**
     * Proxy method
     *
     * @return DocumentManager
     */
    protected function dm() {
        return $this->getDocumentManager();
    }

}
