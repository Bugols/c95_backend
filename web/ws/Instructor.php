<?php

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;

use C95\Domain\Service\InstructorService;

/**
 * @uri /instructor/:id
 */
class Instructor extends \C95\Infrastructure\Resource {

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
        $instructor = $this->service->findById($this->id);
        return new \Tonic\Response(200, $instructor->hydrate(false)->toArray());
    }

    /**
     * @method PUT
     * @json
     */
    public function update() {
        /** @var $dm DocumentManager */
        $dm = $this->container['odm'];

        /** @var $instructor Cursor */
        $dm->createQueryBuilder('\C95\Domain\Instructor')
            ->update()
            ->setNewObj((array)$this->request->data)
            ->field('id')->equals($this->id)
            ->getQuery()
            ->execute();

        return $this->display();
    }

    /**
     * @method DELETE
     */
    public function remove() {
        /** @var $dm DocumentManager */
        $dm = $this->container['odm'];

        $dm->createQueryBuilder('\C95\Domain\Instructor')
            ->findAndRemove()
            ->field('id')->equals($this->id)
            ->getQuery()
            ->execute();
    }

    public function json() {
        $this->before(function($request) {
            if ($request->contentType == "application/json") {
                $request->data = json_decode($request->data);
            }
        });

        $this->after(function($response) {
            $response->contentType = "application/json";
            $response->body = json_encode($response->body);
        });
    }

}
