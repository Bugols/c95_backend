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
     */
    public function display() {
        return new Response(Response::OK, $this->service->findById($this->id));
    }

    /**
     * @method PUT
     * @type C95\Domain\Qualification
     */
    public function update() {
        return new Response(Response::OK, $this->service->update($this->request->data));
    }

    /**
     * @method DELETE
     */
    public function remove() {
        return new Response(Response::OK, $this->service->remove($this->id));
    }

}
