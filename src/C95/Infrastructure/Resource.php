<?php

namespace C95\Infrastructure;

use Pimple;
use JMS\Serializer\SerializerBuilder;
use Tonic\Resource as BaseResource;

class Resource extends BaseResource {

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

    protected function getContainer($index = null) {
        if(is_null($index)) {
            return $this->container;
        }

        if(empty($this->container[$index])) {
            throw new \InvalidArgumentException('Index "' . $index . '" not found in container.');
        }

        return $this->container[$index];
    }

    protected function serializeToJson($object) {
        /** @todo Create serializer handler for the Cursor class */
        if($object instanceof \Doctrine\MongoDB\Cursor) {
            $object = array_values(iterator_to_array($object));
        }

        return $this->getContainer('serializer')->serialize($object, 'json');
    }

    public function deserializeToObject($serializedData, $className) {
        return $this->getContainer('serializer')->deserialize($serializedData, $className, 'json');
    }

    public function json() {
        $this->after(function($response) {
            $response->contentType = "application/json";
            $response->body = $this->serializeToJson($response->body);
        });
    }

}
