<?php

namespace C95\Domain\Service\Web;

use Tonic\Response;

use C95\Infrastructure\Resource;
use C95\Domain\Service\InstructorService;

/**
 * @uri /instructor
 */
class InstructorCollection extends Resource {

    /** @var InstructorService */
    private $service;

    public function init() {
        $this->service = new InstructorService($this->getContainer());
    }

	/**
	 * @method GET
	 */
	public function all() {
        return new Response(Response::OK, $this->service->findAll());
	}

    /**
     * @method POST
     * @type C95\Domain\Instructor
     */
    public function create() {
        return new Response(Response::OK, $this->service->create($this->request->data));
    }

}
