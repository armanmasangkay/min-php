<?php namespace App\Source\Atom;

use PDO;

class Database{

    public static function getConnection()
    {
        $dbName=env("DB_NAME");
        $host=env("DB_HOST");
        $username=env("DB_USERNAME");
        $password=env("DB_PASSWORD");
    
        $dsn = "mysql:host=$host;dbname=$dbName";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, $username, $password, $options);

        } catch (\PDOException $e) {
            
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $pdo;
    }
}