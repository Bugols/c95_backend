<?php

namespace C95\Domain;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Qualification {

    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $name;

}
