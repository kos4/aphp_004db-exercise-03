<?php

namespace Netology;

class ConnectDB
{
  private string $host = 'localhost';
  private string $database = 'netology_hw004db';
  private string $username = 'root';
  private string $password = '12345678';
  protected \PDO $pdo;

  public function __construct()
  {
    $this->pdo = new \PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
  }
}