<?php namespace Maatwebsite\Usher\Infrastructure\Users;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;
use Maatwebsite\Usher\Contracts\Users\User;
use Maatwebsite\Usher\Domain\Users\Embeddables\Name;
use Maatwebsite\Usher\Domain\Users\Embeddables\Email;
use Maatwebsite\Usher\Contracts\Users\UserRepository;
use Maatwebsite\Usher\Domain\Users\Embeddables\Password;
use Maatwebsite\Usher\Contracts\Users\Embeddables\Email as EmailInterface;
use Maatwebsite\Usher\Domain\Users\Events\UserRegistered;
use Maatwebsite\Usher\Domain\Users\Events\UserUpdatedProfile;

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
     * @param EmailInterface $email
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
     * @param  array $credentials
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

        return $this->findOneBy($credentials);
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
     * Deletes a user
     * @param User $user
     */
    public function delete(User $user)
    {
        return $this->_em->remove($user);
    }
}
