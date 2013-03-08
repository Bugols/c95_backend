<?php

namespace C95\Infrastructure;

class Resource extends \Tonic\Resource {

    protected $container;

    public function __construct($app, $request, array $urlParams) {
        parent::__construct($app, $request, $urlParams);

        $this->init();
    }

    protected function init() {
        // Placeholder method
    }

    public function setContainer($container) {
        $this->container = $container;
    }

    protected function getContainer($containerValue = null) {
        if(is_null($containerValue)) {
            return $this->container;
        }

        return $this->container[$containerValue];
    }

}
