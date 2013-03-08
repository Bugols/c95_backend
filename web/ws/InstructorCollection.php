<?php

namespace Web\Resource;

use Tonic\Response;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * @uri /instructor
 */
class InstructorCollection extends \Tonic\Resource {

	/**
	 * @method GET
     * @json
	 */
	public function all() {
        /** @var $repo DocumentRepository */
        $repo = $this->container['odm']->getRepository('C95\Domain\Instructor');

        /** @var $instructor \Doctrine\ODM\MongoDB\Cursor */
        $instructors = $repo->findAll()->hydrate(false);

        return new Response(Response::OK, $instructors->toArray());
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

    public function json() {
        $this->before(function ($request) {
            if ($request->contentType == "application/json") {
                $request->data = json_decode($request->data);
            }
        });
        $this->after(function ($response) {
            $response->contentType = "application/json";
            $response->body = json_encode($response->body);
        });
    }

}
