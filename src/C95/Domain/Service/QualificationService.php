<?php

namespace C95\Domain\Service;

use Doctrine\ODM\MongoDB\DocumentNotFoundException;
use Doctrine\ODM\MongoDB\Cursor;

use C95\Infrastructure\Service;
use C95\Domain\Qualification;

class QualificationService extends Service {

    /** @return Cursor Filled with objects of type Qualification */
    public function findAll() {
        return $this->dm()->createQueryBuilder('C95\Domain\Qualification')->getQuery()->execute();
    }

    /**
     * @param string $qualificationId
     * @return Qualification
     */
    public function findById($qualificationId) {
        return $this->dm()->getRepository('C95\Domain\Qualification')->findOneById($qualificationId);
    }

    /**
     * @param Qualification $qualification
     * @return Qualification
     */
    public function update(Qualification $qualification) {
        $qualification = $this->dm()->merge($qualification);
        $this->dm()->flush();

        return $qualification;
    }

    /**
     * @param Qualification $qualification
     * @return Qualification
     */
    public function create(Qualification $qualification) {
        $this->dm()->persist($qualification);
        $this->dm()->flush();

        return $qualification;
    }

    /**
     * @param string $qualificationId
     * @throws \Doctrine\ODM\MongoDB\DocumentNotFoundException
     * @return Qualification
     */
    public function remove($qualificationId) {
        $qualification = $this->findById($qualificationId);

        if(is_null($qualification)) {
            throw new DocumentNotFoundException('Qualification could not be removed. Reason: no Qualification was found with id: "'. $qualificationId .'"');
        }

        $this->dm()->remove($qualification);
        $this->dm()->flush();

        return $qualification;
    }

}
