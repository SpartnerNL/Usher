<?php namespace Maatwebsite\Usher\Infrastructure\Roles;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;
use Maatwebsite\Usher\Contracts\Roles\Role;
use Maatwebsite\Usher\Contracts\Roles\RoleRepository;
use Maatwebsite\Usher\Domain\Roles\Events\RoleWasCreated;
use Maatwebsite\Usher\Domain\Roles\Events\RoleWasUpdated;

class DoctrineRoleRepository extends EntityRepository implements RoleRepository
{

    /**
     * @var string
     */
    protected $_entityName;

    /**
     * @var EntityManagerInterface
     */
    protected $_em;

    /**
     * @var ClassMetadata
     */
    protected $_class;

    /**
     * Initializes a new <tt>EntityRepository</tt>.
     *
     * @param EntityManagerInterface $em    The EntityManager to use.
     * @param ClassMetadata          $class The class descriptor.
     */
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        $this->_em = $em;
        $this->_class = $class;
        $this->_entityName = $class->name;
    }

    /**
     * Returns all the users
     * @return object
     */
    public function all()
    {
        return $this->findAll();
    }

    /**
     * Find a role by its name
     * @param  string $name
     * @return mixed
     */
    public function findByName($name)
    {
        return $this->findOneBy([
            'name' => $name
        ]);
    }

    /**
     * Persist entity
     * @param $entity
     * @return mixed
     */
    public function persist($entity)
    {
        return $this->_em->persist($entity);
    }

    /**
     * Flush entity manager
     * @return mixed
     */
    public function flush()
    {
        return $this->_em->flush();
    }

    /**
     * Deletes a role
     * @param Role $role
     */
    public function delete(Role $role)
    {
        return $this->_em->remove($role);
    }
}
