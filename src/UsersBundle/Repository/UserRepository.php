<?php
namespace UsersBundle\Repository;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use UsersBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;
class UserRepository implements UserProviderInterface
{
    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public static $TABLEUSER = "User";
    public static $ID = "_ID";
    public static $USERNAME = "username";
    public static $PASSWORD = "password";
    public static $NAME = "name";
    public static $SURNAME = "surname";
    public static $PHONE = "phone";
    public static $EMAIL = "email";
    public static $DATE = "date";
    public static $ROLES = "roles";

    /**
     * {@inheritDoc}
     */
    public function find($id) {
        $sql = "select * from ".UserRepository::$TABLEUSER." where ".UserRepository::$ID."=?";
        $row = $this->db->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching id " . $id);
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from ".UserRepository::$TABLEUSER." where ".UserRepository::$USERNAME."=?";
        $row = $this->db->fetchAssoc($sql, array($username));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'UsersBundle\Entity\User' === $class;
    }

    /**
     * Creates a User object based on a DB row.
     *
     * @param array $row The DB row containing User data.
     * @return \UsersBundle\Entity\User
     */
    protected function buildDomainObject(array $row) {
        $user = new User();
        $user->setId($row[UserRepository::$ID]);
        $user->setUsername($row[UserRepository::$USERNAME]);
        $user->setPassword($row[UserRepository::$PASSWORD]);
        $user->setName($row[UserRepository::$NAME]);
        $user->setSurname($row[UserRepository::$SURNAME]);
        $user->setPhone($row[UserRepository::$PHONE]);
        $user->setEmail($row[UserRepository::$EMAIL]);
        $user->setDate($row[UserRepository::$DATE]);
        $user->setRole($row[UserRepository::$ROLES]);

        return $user;
    }
}