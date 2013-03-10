<?php

namespace C95\Domain\Service;

use Doctrine\ODM\MongoDB\Cursor;

use C95\Infrastructure\Service;
use C95\Domain\Instructor;

class InstructorService extends Service {

    /** @return Cursor Filled with objects of type Instructor */
    public function findAll() {
        return $this->dm()->createQueryBuilder('C95\Domain\Instructor')->getQuery()->execute();
    }

    /**
     * @param string $instructorId
     * @return Instructor
     */
    public function findById($instructorId) {
        return $this->dm()->getRepository('C95\Domain\Instructor')->findOneById($instructorId);
    }

    /**
     * @param Instructor $instructor
     * @return Instructor
     */
    public function update(Instructor $instructor) {
        $instructor = $this->dm()->merge($instructor);
        $this->dm()->flush();

        return $instructor;
    }

    /**
     * @param Instructor $instructor
     * @return Instructor
     */
    public function create(Instructor $instructor) {
        $this->dm()->persist($instructor);
        $this->dm()->flush();

        return $instructor;
    }

    /**
     * @param string $instructorId
     * @return Instructor
     */
    public function remove($instructorId) {
        $instructor = $this->findById($instructorId);
        $this->dm()->remove($instructor);
        $this->dm()->flush();

        return $instructor;
    }

}
