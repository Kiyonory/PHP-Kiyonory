<?php

namespace src\Services;

use stdClass;

class Db{
    private $connect;
    private static $instance;

    private function __construct()
    {
        $dbOptions = [
            'host' => 'localhost',
            'dbname' => 'project_php',
            'user' => 'postgres',
            'password' => 'postgres'
        ];
        
        $this->connect = new \PDO(
            'pgsql:host=' . $dbOptions['host'] . ';dbname=' . $dbOptions['dbname'],
            $dbOptions['user'],
            $dbOptions['password']
        );
    }

    public static function getInstance(){
        if (!self::$instance) return self::$instance = new self;
        else return self::$instance;
    }

    public function query($sql, $params = [], $className='stdClass'): ?array
    {
        $sth = $this->connect->prepare($sql);
        $result = $sth->execute($params);
        if ($result == false) return null;
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }
}