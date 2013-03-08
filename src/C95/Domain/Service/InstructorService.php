<?php

namespace C95\Domain\Service;

class InstructorService extends \C95\Infrastructure\Service {

    public function findAll() {
        return $this->dm()->getRepository('Instructor')->findAll();
    }

    /**
     * @param $instructorId
     * @return mixed
     */
    public function findById($instructorId) {
        return $this->container['odm']->getRepository('\C95\Domain\Instructor')->findOneById($instructorId)->hydrate(false);
    }

}
