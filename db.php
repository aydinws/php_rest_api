<?php 

  class Database
  {
    private $host = 'localhost';
    private $db_name = 'db';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect()
    {
      $this->conn = null;

      try
      {
        $this->conn = new PDO('mysql:host=' . $this->host . ';dbname='. $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch(PDOException $err)
      {
        echo 'Connection err: ' . $err->getMessage();
      }

      return $this->conn;
    }

    
  }