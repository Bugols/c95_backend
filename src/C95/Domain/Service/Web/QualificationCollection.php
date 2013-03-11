<?php

namespace C95\Domain\Service\Web;

use Tonic\Response;

use C95\Infrastructure\Resource;
use C95\Domain\Service\QualificationService;

/**
 * @uri /qualification
 */
class QualificationCollection extends Resource {

    /** @var QualificationService */
    private $service;

    public function init() {
        $this->service = new QualificationService($this->getContainer());
    }

	/**
	 * @method GET
	 */
	public function all() {
        return new Response(Response::OK, $this->service->findAll());
	}

    /**
     * @method POST
     * @type C95\Domain\Qualification
     */
    public function create() {
        $qualification = $this->deserializeToObject($this->request->data, 'C95\Domain\Qualification');
        return new Response(Response::OK, $this->service->create($qualification));
    }

}
