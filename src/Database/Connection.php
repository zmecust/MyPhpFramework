<?php
namespace Laravue\Database;

use PDO;
use Laravue\Application;

/**
 * Connection represents a connection to a database via [PDO](php.net/manual/en/book.pdo.php).
 * @author Harry Sun <sunguangjun@126.com>
 */
class Connection
{
    /**
     * @var string the Data Source Name, or DSN, contains the information required to connect to the database.
     * Please refer to the [PHP manual](http://www.php.net/manual/en/function.PDO-construct.php) on
     * the format of the DSN string.
     * @see charset
     */
    public $dsn;

    /**
     * @var string the username for establishing DB connection. Defaults to `null` meaning no username to use.
     */
    public $username;

    /**
     * @var string the password for establishing DB connection. Defaults to `null` meaning no password to use.
     */
    public $password;

    /**
     * @var array PDO attributes (name => value)
     * to establish a DB connection. Please refer to the
     * [PHP manual](http://www.php.net/manual/en/function.PDO-setAttribute.php) for
     * details about available attributes.
     */
    public $attributes;

    public function __construct($config)
    {
        $database_config = Application::getInstance()->config[$config];
        foreach ($database_config as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getDb()
    {
        return new PDO($this->dsn, $this->username, $this->password, $this->attributes);
    }
}
