<?php

namespace UsersBundle\Controller;

use Silex\Application;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    private $db;
    public static $tableUser = "User";
    public static $id = "_ID";
    public static $username = "username";
    public static $password = "password";
    public static $name = "name";
    public static $surname = "surname";
    public static $phone = "phone";
    public static $email = "email";
    public static $date = "date";
    public static $roles = "roles";

    public function __construct(Connection $db)
    {       
        $this->db=$db;
    }

	public function install(Application $app)
	{
		$schema = $this->db->getSchemaManager();



		if (!$schema->tablesExist(DefaultController::$tableUser)) 
		{
			//TABLE
			$users = new Table(DefaultController::$tableUser);
			//id
			$users->addColumn(DefaultController::$id, 'integer', array('unsigned' => true, 'autoincrement' => true));
			$users->setPrimaryKey(array(DefaultController::$id));

			//username
			$users->addColumn(DefaultController::$username, 'string', array('length' => 32));	 
            $users->addUniqueIndex(array(DefaultController::$username));

            //password
            $users->addColumn(DefaultController::$password, 'string', array('length' => 255));

            //name
            $users->addColumn(DefaultController::$name, 'string', array('length' => 255));

            //surname
            $users->addColumn(DefaultController::$surname, 'string', array('length' => 255));

            //phone
            $users->addColumn(DefaultController::$phone, 'string', array('length' => 32));

            //email
            $users->addColumn(DefaultController::$email, 'string', array('length' => 255));


            $users->addColumn(DefaultController::$date, 'string');

            //roles
            $users->addColumn(DefaultController::$roles, 'string');

            $schema->createTable($users);


            return true;
		}
			return false;
	}
    public function test()
    {
        return 101;
    }
}