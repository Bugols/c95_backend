<?php

namespace C95\Domain\Service;

use Doctrine\ODM\MongoDB\Cursor;

class InstructorService extends \C95\Infrastructure\Service {

    /** @return \Doctrine\ODM\MongoDB\Cursor */
    public function findAll() {
        return $this->dm()->getRepository('C95\Domain\Instructor')->findAll();
    }

    /**
     * @param string $instructorId
     * @return \Doctrine\ODM\MongoDB\Cursor
     */
    public function findById($instructorId) {
        return $this->dm()->getRepository('C95\Domain\Instructor')->findById($instructorId);
    }

}
