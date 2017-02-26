<?php

/*
 * This file is part of the GraphAware Neo4j PHP OGM package.
 *
 * (c) GraphAware Ltd <info@graphaware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GraphAware\Neo4j\OGM\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use GraphAware\Neo4j\OGM\EntityManager;
use GraphAware\Neo4j\OGM\Metadata\NodeEntityMetadata;

class BaseRepository implements ObjectRepository
{
    /**
     * @var \GraphAware\Neo4j\OGM\Metadata\ClassMetadata
     */
    protected $classMetadata;

    /**
     * @var \GraphAware\Neo4j\OGM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $className;

    /**
     * @param \GraphAware\Neo4j\OGM\Metadata\ClassMetadata $classMetadata
     * @param \GraphAware\Neo4j\OGM\EntityManager          $manager
     * @param string                                       $className
     */
    public function __construct(NodeEntityMetadata $classMetadata, EntityManager $manager, $className)
    {
        $this->classMetadata = $classMetadata;
        $this->entityManager = $manager;
        $this->className = $className;
    }

    /**
     * @param int $id
     *
     * @return null|object
     */
    public function find($id)
    {
        return $this->findOneById($id);
    }


    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy([]);
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $persister = $this->entityManager->getEntityPersister($this->className);

        return $persister->loadAll($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return object|null
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        $persister = $this->entityManager->getEntityPersister($this->className);

        return $persister->load($criteria);
    }

    /**
     * @param int $id
     *
     * @return object|null
     */
    public function findOneById($id)
    {
        $persister = $this->entityManager->getEntityPersister($this->className);

        return $persister->loadOneById($id);
    }


    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }
}
