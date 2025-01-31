<?php

namespace Netology;

use Netology\ConnectDB;

class Order extends ConnectDB
{
  protected string $table = 'order';
  protected array $orders = [
    [
      'shop_id' => 1,
      'client_id' => 1,
    ],
    [
      'shop_id' => 2,
      'client_id' => 2,
    ],
    [
      'shop_id' => 3,
      'client_id' => 3,
    ],
    [
      'shop_id' => 4,
      'client_id' => 4,
    ],
    [
      'shop_id' => 5,
      'client_id' => 5,
    ],
  ];

  public function createTable(): \PDOStatement|false
  {
    $sql = "CREATE TABLE IF NOT EXISTS `$this->table` (
      id INT AUTO_INCREMENT PRIMARY KEY,
      shop_id INT,
      client_id INT,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      CONSTRAINT order_shop_fk FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE,
      CONSTRAINT order_client_fk FOREIGN KEY (client_id) REFERENCES `client` (id) ON DELETE CASCADE
    )";
    return $this->pdo->query($sql);
  }

  public function insertTestData(array $orders = []): void
  {
    $query = $this->pdo->query("SELECT * FROM `$this->table`");

    if (!$query->rowCount()) {
      $sql = "INSERT INTO `$this->table`(shop_id, client_id) VALUES(:shop_id, :client_id)";
      $stmt = $this->pdo->prepare($sql);

      if (!count($orders)) {
        $orders = $this->orders;
      }

      foreach ($orders as $order) {
        $stmt->bindValue(':shop_id', $order['shop_id']);
        $stmt->bindValue(':client_id', $order['client_id']);
        $stmt->execute();
      }
    }
  }

  public function insert(array $tableColumns, array $values): array
  {
    $result = null;

    $sql = "INSERT INTO `$this->table`(" . implode(',', $tableColumns) . ") VALUES(?,?)";
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
    $sql = "UPDATE `$this->table` SET shop_id=:shop_id, client_id=:client_id WHERE id=:id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($values);

    return $this->find($id);
  }

  public function find(int $id): array
  {
    $sql = "SELECT * FROM `$this->table` WHERE id=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function delete(int $id): bool
  {
    $sql = "DELETE FROM `$this->table` WHERE id=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);

    return (bool) $stmt->rowCount();
  }
}