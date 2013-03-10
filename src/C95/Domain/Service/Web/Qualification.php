<?php

namespace C95\Domain\Service\Web;

use Tonic\Response;

use C95\Infrastructure\Resource;
use C95\Domain\Service\QualificationService;

/**
 * @uri /qualification/:id
 */
class Qualification extends Resource {

    /** @var QualificationService */
    private $service;

    public function init() {
        $this->service = new QualificationService($this->getContainer());
    }

    /**
     * @method GET
     * @json
     */
    public function display() {
        return new Response(Response::OK, $this->service->findById($this->id));
    }

    /**
     * @method PUT
     * @json
     */
    public function update() {
        $qualification = $this->deserializeToObject($this->request->data, 'C95\Domain\Qualification');
        return new Response(Response::OK, $this->service->update($qualification));
    }

    /**
     * @method DELETE
     * @json
     */
    public function remove() {
        return new Response(Response::OK, $this->service->remove($this->id));
    }

}
