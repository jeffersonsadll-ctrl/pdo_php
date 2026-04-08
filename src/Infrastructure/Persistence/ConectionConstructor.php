<?php

class ConectionConstructor
{
    public static function createConnection(): \PDO
    {
        $connection = new \PDO('sqlite:' . __DIR__ . '/../../../banco.sqlite');

        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $connection;
    }
}