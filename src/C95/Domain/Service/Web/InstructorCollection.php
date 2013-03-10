<?php

namespace C95\Domain\Service\Web;

use Tonic\Response;

use C95\Infrastructure\Resource;
use C95\Domain\Service\InstructorService;

/**
 * @uri /instructor
 */
class InstructorCollection extends Resource {

    /**
     * @var InstructorService
     */
    private $service;

    public function init() {
        $this->service = new InstructorService($this->getContainer());
    }

	/**
	 * @method GET
     * @json
	 */
	public function all() {
        return new Response(Response::OK, $this->service->findAll());
	}

    /**
     * @method POST
     * @json
     */
    public function create() {
        $instructor = $this->deserializeToObject($this->request->data, 'C95\Domain\Instructor');
        return new Response(Response::OK, $this->service->create($instructor));
    }

}
