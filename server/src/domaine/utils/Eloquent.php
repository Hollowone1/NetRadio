<?php

namespace radio\net\domaine\utils;

use Illuminate\Database\Capsule\Manager;

class Eloquent
{
    private $db;
    public function __construct()
    {
        $this->db = new Manager();
    }

    public function init($filename, $connectionName){
        $this->db->addConnection(parse_ini_file($filename), $connectionName);
        $this->db->bootEloquent();
        $this->db->setAsGlobal();
    }
}