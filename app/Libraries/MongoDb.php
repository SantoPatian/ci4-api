<?php

namespace App\Libraries;

class MongoDb
{
    private $conn;

    function __construct()
    {
        $config = new \Config\MongoDbConfig();

        $host = $config->host;
        $port = $config->port;
        $username = $config->username;
        $password = $config->password;
        $authRequired = $config->authRequired;

        try {
            if ($authRequired) {
                $this->conn = new \MongoDB\Driver\Manager('mongodb://'. $username .':'. $password .'@'. $host .':'. $port);
            } else {
                $this->conn = new \MongoDB\Driver\Manager('mongodb://'. $host .':'. $port);
            }
        } catch ( \MongoDB\Driver\Exception\MongoConnectionException $ex ){
            show_error('Couldnot connect to mongodd: '. $ex->getMessage(), 500);
        }
    }

    function getConn() {
        return $this->conn;
    }
}