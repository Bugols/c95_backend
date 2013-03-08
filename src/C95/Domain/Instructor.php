<?php

namespace C95\Domain;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Instructor {

    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $firstName;

    /** @ODM\String */
    private $lastName;

    /** @ODM\ReferenceMany(targetDocument="Qualification") */
    private $qualifications;

    /** @return string */
    public function getFirstName() { return $this->firstName; }

}
