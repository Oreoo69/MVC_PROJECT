<?php
class Database {
    //these are like the login details for our database
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    //we'll use these to store important stuff for our database connection
    private $dbh;      //this holds our database connection
    private $stmt;     //this is where we'll put our SQL commands
    private $error;    //if something goes wrong, we'll put the error message here

    //this runs automatically when we create a new Database connection
    public function __construct() {
        //this is the address of our database
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        //these are some settings to make our connection work better
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        //we try to connect to the database here
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            //if something goes wrong, we catch the error and show it
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    //this function helps us write SQL commands
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }

    //this function helps us put values safely into our SQL commands
    public function bind($param, $value, $type = null) {
        if(is_null($type)) {
            //we check what kind of value we're dealing with
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;    //if it's a number
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;   //if it's true/false
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;   //if it's null
                    break;
                default:
                    $type = PDO::PARAM_STR;    //if it's text
            }
        }
        //we safely add the value to our SQL command
        $this->stmt->bindValue($param, $value, $type);
    }

    //this runs our SQL command
    public function execute() {
        return $this->stmt->execute();
    }

    //this gets all the results from our SQL command
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    //this gets just one result from our SQL command
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
}
?>