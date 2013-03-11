<?php

namespace C95\Infrastructure;

use Pimple;
use Tonic\Resource as BaseResource;

use JMS\Serializer\Exception\ValidationFailedException;

class Resource extends BaseResource {

    /** @var Pimple */
    protected $container;

    /** @var string */
    public $classType = null;

    /**
     * Initialize any resources at construction
     */
    public function init() {
        // Placeholder method
    }

    public function setContainer(Pimple $container) {
        $this->container = $container;
    }

    public function getContainer($index = null) {
        if(is_null($index)) {
            return $this->container;
        }

        if(empty($this->container[$index])) {
            throw new \InvalidArgumentException('Index "' . $index . '" not found in container.');
        }

        return $this->container[$index];
    }

    public function handleResponse($response) {
        /** @todo Create serializer handler for the Cursor class */
        if($response->body instanceof \Doctrine\MongoDB\Cursor) {
            $response->body = iterator_to_array($response->body);
        }

        $response->contentType = "application/json";
        $response->body = $this->getContainer('serializer')->serialize($response->body, 'json');
    }

    public function handleRequest($request) {
        if($request->contentType != "application/json") {
            throw new \InvalidArgumentException('Wrong content type found in HTTP headers, expected application/json but got '.$request->contentType);
        }

        if(strlen($this->classType) < 1) {
            throw new \InvalidArgumentException('Class type annotation is missing/wrong in Resource class. Got value: '.$this->classType);
        }

        $document = $this->getContainer('serializer')->deserialize($request->data, $this->classType, 'json');
        $violations = $this->getContainer('validator')->validate($document);

        if(count($violations) > 0) {
            throw new ValidationFailedException($violations);
        }

        $request->data = $document;
    }

    public function type($classType) {
        $this->classType = (string) $classType;

        $this->before(function($request) {
            $this->handleRequest($request);
        });
    }

}
