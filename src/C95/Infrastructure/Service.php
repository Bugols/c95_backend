<?php

namespace C95\Infrastructure;

use Doctrine\ODM\MongoDB\DocumentManager;

abstract class Service {

    /** @var DocumentManager */
    private $documentManager;

    public function __construct(DocumentManager $documentManager) {
        $this->setDocumentManager($documentManager);
    }

    /** @param $documentManager DocumentManager */
    public function setDocumentManager(DocumentManager $documentManager) {
        $this->documentManager = $documentManager;
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
