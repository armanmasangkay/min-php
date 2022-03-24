<?php namespace App\Source\Atom;

use Exception;
use PDO;

class Model{

    private string $tableName;
    private $connection;
    private $whereSql;

    public function __construct($tableName)
    {
        $this->connection=Database::getConnection();
        $this->tableName=$tableName;
    }

    public function all()
    {
        $sql="SELECT * FROM $this->tableName";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    } 

    public function where($column,$value)
    {
        $this->whereSql="WHERE $column='$value'";
        return $this;
    }

    private function checkIfWhereIsCalled()
    {
        if(empty($this->whereSql)){
            throw new Exception("You must call 'where' function first");
        }
    }
    public function get()
    {
        $this->checkIfWhereIsCalled();
        $sql="SELECT * FROM $this->tableName ".$this->whereSql;
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $data=$statement->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]??null;
    }

    public function update(array $newValues)
    {
        $this->checkIfWhereIsCalled();

        $setValue="SET ";
        foreach ($newValues as $key=>$value){
            $setValue.="$key='$value', ";
        }
        $set=substr($setValue,0,strlen($setValue)-2);

        $sql="UPDATE $this->tableName $set $this->whereSql";
        $statement = $this->connection->prepare($sql);
        return $statement->execute();
    }

    public function delete()
    {
        $this->checkIfWhereIsCalled();

        $sql="DELETE FROM $this->tableName $this->whereSql";
        return $this->connection->prepare($sql)->execute();
    }
}