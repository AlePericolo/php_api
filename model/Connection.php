<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 26/11/19
 * Time: 11.36
 */

require_once '../conf/conf.php';

class Connection
{

    private $host;
    private $port;
    private $database;
    private $username;
    private $password;

    public $conn;

    /**
     * Connection constructor.
     */
    public function __construct()
    {
        $this->host = constant("HOST");
        $this->port = constant("PORT" );
        $this->database = constant("DATABASE");
        $this->username = constant("USERNAME");
        $this->password = constant("PASSWORD");
    }


    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO(
                                'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->database,
                                $this->username,
                                $this->password,
                                array(PDO::ATTR_PERSISTENT => true)
                            );

            $this->conn->exec("set names utf8");
            
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}