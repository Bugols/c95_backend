<?php

namespace C95\Infrastructure;

use Pimple;

class Resource extends \Tonic\Resource {

    /**
     * @var Pimple
     */
    protected $container;

    public function init() {
        // Placeholder method
    }

    public function setContainer(Pimple $container) {
        $this->container = $container;
    }

    protected function getContainer() {
        return $this->container;
    }

}
