<?php namespace Maatwebsite\Usher\Infrastructure\Users;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Email as EmailInterface;
use Maatwebsite\Usher\Contracts\Users\User;
use Maatwebsite\Usher\Contracts\Users\UserRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepository
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
     * Find user by email
     *
     * @param EmailInterface $email
     *
     * @return mixed
     */
    public function findByEmail(EmailInterface $email)
    {
        return $this->findOneBy(array(
            'email.email' => $email->getEmail()
        ));
    }

    /**
     * Find a user by its credentials
     *
     * @param  array $credentials
     *
     * @return mixed
     */
    public function findByCredentials(array $credentials)
    {
        $creds = array();

        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password')) {
                if ($key == 'email') {
                    $creds['email.email'] = $credentials['email'];
                } else {
                    $creds[$key] = $value;
                }
            }
        }

        $builder = $this->createQueryBuilder('u');
        $builder->select('u', 'r');
        $builder->join('u.roles', 'r');

        foreach ($creds as $name => $value) {
            $builder->where('u.' . $name . ' = :' . $name);
        }

        $query = $builder->getQuery();
        foreach ($creds as $name => $value) {
            $query->setParameter($name, $value);
        }

        return $query->getOneOrNullResult();
    }

    /**
     * @param $id
     *
     * @return User
     */
    public function findWithRole($id)
    {
        $builder = $this->createQueryBuilder('u');
        $builder->select('u', 'r');
        $builder->join('u.roles', 'r');

        $builder->where('u.id = :id');

        $query = $builder->getQuery();
        $query->setParameter('id', $id);

        return $query->getSingleResult();
    }

    /**
     * @param $criteria
     *
     * @return User
     */
    public function findWithRoleByCriteria($criteria)
    {
        $builder = $this->createQueryBuilder('u');
        $builder->select('u', 'r');
        $builder->join('u.roles', 'r');

        foreach ($criteria as $name => $value) {
            $builder->where('u.' . $name . ' = :' . $name);
        }

        $query = $builder->getQuery();
        foreach ($criteria as $name => $value) {
            $query->setParameter($name, $value);
        }

        return $query->getOneOrNullResult();
    }

    /**
     * Persist entity
     *
     * @param $entity
     *
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
     * Deletes a user
     *
     * @param User $user
     */
    public function delete(User $user)
    {
        return $this->_em->remove($user);
    }
}
