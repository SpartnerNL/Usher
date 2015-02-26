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
        $this->_entityName = $class->name;
        $this->_em = $em;
        $this->_class = $class;
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
     * Create a user resource
     * @param  array $data
     * @return User
     */
    public function create(array $data)
    {
        $user = new $this->_entityName;

        $user->setName(
            new Name(
                $data['firstname'],
                $data['lastname']
            )
        );

        $user->setEmail(new Email(
            $data['email']
        ));

        $user->setPassword(new Password(
            $data['password']
        ));

        event(new UserRegistered($user));

        return $user;
    }

    /**
     * Create a user and assign roles to it
     * @param  array $data
     * @param  array $roles
     * @return void
     */
    public function createWithRoles($data, $roles)
    {
        // TODO: Implement createWithRoles() method.
    }

    /**
     * Update a user
     * @param User  $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data)
    {
        $user->setName(
            new Name(
                $data['firstname'],
                $data['lastname']
            )
        );

        $user->setEmail(new Email(
            $data['email']
        ));

        $password = new Password($data['password']);

        if (!$password->equals($user->getPassword())) {
            $user->setPassword($password);
        }

        event(new UserUpdatedProfile($user));

        return $user;
    }

    /**
     * Update a user and sync its roles
     * @param  int $userId
     * @param      $data
     * @param      $roles
     * @return mixed
     */
    public function updateAndSyncRoles($userId, $data, $roles)
    {
        // TODO: Implement updateAndSyncRoles() method.
    }

    /**
     * Deletes a user
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $user = $this->find($id);

        parent::delete($user);
    }

    /**
     * Find a user by its credentials
     * @param  array $credentials
     * @return mixed
     */
    public function findByCredentials(array $credentials)
    {
        if (isset($credentials['password'])) {
            unset($credentials['password']);
        }

        // Transform to embeddable ready key
        if (isset($credentials['email'])) {
            $credentials['email.email'] = $credentials['email'];
            unset($credentials['email']);
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
}
