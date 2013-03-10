<?php

namespace C95\Infrastructure\JMS\Serializer\Construction;

use Doctrine\ODM\MongoDB\DocumentManager;

use JMS\Serializer\VisitorInterface;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\Construction\DoctrineObjectConstructor as BaseConstructor;

/**
 * Doctrine object constructor for new (or existing) objects during deserialization.
 */
class DoctrineObjectConstructor extends BaseConstructor implements ObjectConstructorInterface
{
    /** @var \Doctrine\ODM\MongoDB\DocumentManager */
    private $documentManager;

    /** @var \JMS\Serializer\Construction\ObjectConstructorInterface */
    private $fallbackConstructor;

    /**
     * Constructor.
     *
     * @param DocumentManager            $documentManager     Document manager
     * @param ObjectConstructorInterface $fallbackConstructor Fallback object constructor
     */
    public function __construct(DocumentManager $documentManager, ObjectConstructorInterface $fallbackConstructor) {
        $this->documentManager     = $documentManager;
        $this->fallbackConstructor = $fallbackConstructor;
    }

    /** {@inheritdoc} */
    public function construct(VisitorInterface $visitor, ClassMetadata $metadata, $data, array $type) {
        // Locate possible ObjectManager
        $objectManager = $this->documentManager;

        if (!$objectManager) {
            // No ObjectManager found, proceed with normal deserialization
            return $this->fallbackConstructor->construct($visitor, $metadata, $data, $type);
        }

        // Locate possible ClassMetadata
        $classMetadataFactory = $objectManager->getMetadataFactory();

        if ($classMetadataFactory->isTransient($metadata->name)) {
            // No ClassMetadata found, proceed with normal deserialization
            return $this->fallbackConstructor->construct($visitor, $metadata, $data, $type);
        }

        // Managed entity, check for proxy load
        if (!is_array($data)) {
            // Single identifier, load proxy
            return $objectManager->getReference($metadata->name, $data);
        }

        // Fallback to default constructor if missing identifier(s)
        $classMetadata  = $objectManager->getClassMetadata($metadata->name);
        $identifierList = array();

        foreach ($classMetadata->getIdentifierFieldNames() as $name) {
            if ( ! array_key_exists($name, $data)) {
                return $this->fallbackConstructor->construct($visitor, $metadata, $data, $type);
            }

            $identifierList[$name] = $data[$name];
        }

        // Entity update, load it from database
        $object = $objectManager->find($metadata->name, $identifierList);

        $objectManager->initializeObject($object);

        return $object;
    }
}
