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

    public function json() {
        $this->before(function($request) {
            if ($request->contentType == "application/json") {
                $request->data = json_decode($request->data);
            }
        });

        $this->after(function($response) {
            $response->contentType = "application/json";
            $response->body = json_encode(array('data' => $response->body));
        });
    }

}
