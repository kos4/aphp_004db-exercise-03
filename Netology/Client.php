<?php

namespace Netology;

use Netology\ConnectDB;

class Client extends ConnectDB
{
  protected string $table = 'client';
  protected array $clients = [
    [
      'name' => 'Иван',
      'phone' => '89121112233',
    ],
    [
      'name' => 'Сергей',
      'phone' => '89112221144',
    ],
    [
      'name' => 'Екатерина',
      'phone' => '89059992134',
    ],
    [
      'name' => 'Мария',
      'phone' => '89107776644',
    ],
    [
      'name' => 'Вася',
      'phone' => '89006665533',
    ],
  ];

  public function createTable(): \PDOStatement|false
  {
    $sql = "CREATE TABLE IF NOT EXISTS $this->table (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name CHAR(255),
      phone CHAR(20)
    )";
    return $this->pdo->query($sql);
  }

  public function insertTestData(array $clients = []): void
  {
    $query = $this->pdo->query("SELECT * FROM $this->table");

    if (!$query->rowCount()) {
      $sql = "INSERT INTO $this->table(name, phone) VALUES(:name, :phone)";
      $stmt = $this->pdo->prepare($sql);

      if (!count($clients)) {
        $clients = $this->clients;
      }

      foreach ($clients as $client) {
        $stmt->bindValue(':name', $client['name']);
        $stmt->bindValue(':phone', $client['phone']);
        $stmt->execute();
      }
    }
  }

  public function insert(array $tableColumns, array $values): array
  {
    $result = null;

    $sql = "INSERT INTO $this->table(" . implode(',', $tableColumns) . ") VALUES(?,?)";
    $stmt = $this->pdo->prepare($sql);
    $this->pdo->beginTransaction();
    foreach ($values as $row) {
      $result[] = $stmt->execute($row);
    }
    $this->pdo->commit();

    return $result;
  }

  public function update(int $id, array $values): array
  {
    $values['id'] = $id;
    $sql = "UPDATE $this->table SET name=:name, phone=:phone WHERE id=:id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($values);

    return $this->find($id);
  }

  public function find(int $id): array
  {
    $sql = "SELECT * FROM $this->table WHERE id=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM $this->table WHERE id=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);

    return (bool) $stmt->rowCount();
  }
}