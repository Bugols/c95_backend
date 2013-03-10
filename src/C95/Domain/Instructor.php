<?php

namespace C95\Domain;

use Doctrine\Common\Collections\ArrayCollection;

class Instructor  {

    /** @var string */
    protected $id;

    /** @var string */
    protected $firstName;

    /** @var string */
    protected $lastName;

    /** @var \Doctrine\Common\Collections\ArrayCollection */
    protected $qualifications;

    public function __construct() {
        $this->qualifications = new ArrayCollection();
    }

    /** @param string $id */
    public function setId($id) {
        $this->id = $id;
    }

    /** @return string */
    public function getId() {
        return $this->id;
    }

    /** @param string $firstName */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /** @return string */
    public function getFirstName() {
        return $this->firstName;
    }

    /** @param string $lastName */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /** @return string */
    public function getLastName() {
        return $this->lastName;
    }

    /** @param array $qualifications */
    public function setQualifications(array $qualifications) {
        $this->qualifications = new ArrayCollection($qualifications);
    }

    /** @return \Doctrine\Common\Collections\ArrayCollection */
    public function getQualifications() {
        return $this->qualifications;
    }

    /** @param Qualification $qualification */
    public function addQualification(Qualification $qualification) {
        $this->qualifications->add($qualification);
    }

}
