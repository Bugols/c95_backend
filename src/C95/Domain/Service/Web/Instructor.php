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
        $instructor = $this->deserializeToObject($this->request->data, 'C95\Domain\Instructor');
        return new Response(Response::OK, $this->service->update($instructor));
    }

    /**
     * @method DELETE
     * @json
     */
    public function remove() {
        return new Response(Response::OK, $this->service->remove($this->id));
    }

}
