<?php

namespace C95\Domain\Service\Web;

use Tonic\Response;

use C95\Infrastructure\Resource;
use C95\Domain\Service\InstructorService;

/**
 * @uri /instructor/:id
 */
class Instructor extends Resource {

    /** @var InstructorService */
    private $service;

    public function init() {
        $this->service = new InstructorService($this->getContainer());
    }

    /**
     * @method GET
     */
    public function display() {
        return new Response(Response::OK, $this->service->findById($this->id));
    }

    /**
     * @method PUT
     * @type C95\Domain\Instructor
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
