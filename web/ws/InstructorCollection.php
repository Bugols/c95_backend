<?php

namespace Web\Resource;

use Tonic\Response;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;

use C95\Domain\Service\InstructorService;

/**
 * @uri /instructor
 */
class InstructorCollection extends \C95\Infrastructure\Resource {

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
        $instructors = $this->service->findAll();
        return new Response(Response::OK, $instructors->hydrate(false)->toArray());
	}

    /**
     * @method POST
     * @json
     */
    public function add() {
        /** @var $dm DocumentManager */
        $dm = $this->container['odm'];

        $requestData = (array)$this->request->data;

        $isCreated = $dm->getDocumentCollection('C95\Domain\Instructor')
            ->insert($requestData);

        return new Response(Response::OK, $isCreated);
    }

}
