<?php

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;

    public function __construct()
    {
        $this->host = 'db';
        $this->db_name = 'asknicely';
        $this->username = 'user';
        $this->password = 'password';
    }

    public function connect()
    {
        try {
            $mysqli = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            $mysqli->set_charset("utf8mb4");
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $mysqli;
    }
}
