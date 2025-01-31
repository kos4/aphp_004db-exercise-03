<?php

namespace Netology;

abstract class ConnectDB implements DatabaseWrapper
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

  abstract public function createTable(): \PDOStatement|false;

  abstract public function insertTestData(array $shops): void;
}