<?php 
namespace Conqui;

use Conqui\Traits\SingletonTrait;

use PDO;

class Database{
    private $dbName = DB_NAME;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbHost = DB_HOST;
    private $dbh;
    private $stmt;
    private $error;

    use SingletonTrait;

    public function __construct(){
        $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName.';';
        $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {

        $this->dbh = new PDO($dsn,$this->dbUser,$this->dbPass,$options);

        } catch (PDOException $e  ) {
            $this->error = $e->getMessage();
            print_r($e->getTrace());
            die('Unable to connect to database');
        }
    }    

    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);

    }
    public function bind($param,$value,$type=null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }
    
    public function getInsertId(){
        return  $this->dbh->lastInsertId();
    }

    public function execute(){
    return $this->stmt->execute();
    }

    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function resultSingle(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount(){
        $this->execute();
        return $this->stmt->rowCount();
    }

}