<?php

namespace Netology;

use Netology\ConnectDB;

class Product extends ConnectDB implements DatabaseWrapper
{
  protected string $table = 'product';
  protected array $products = [
    [
      'name' => 'Хлеб',
      'price' => 50,
      'count' => 100,
    ],
    [
      'name' => 'Молоко',
      'price' => 100,
      'count' => 50,
    ],
    [
      'name' => 'Сыр',
      'price' => 150,
      'count' => 30,
    ],
    [
      'name' => 'Кефир',
      'price' => 90,
      'count' => 40,
    ],
    [
      'name' => 'Сметана',
      'price' => 50,
      'count' => 10,
    ],
  ];

  public function createTable(): \PDOStatement|false
  {
    $sql = "CREATE TABLE IF NOT EXISTS $this->table (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name CHAR(255),
      price FLOAT DEFAULT 0,
      count INT DEFAULT 0
    )";
    return $this->pdo->query($sql);
  }

  public function insertTestData(array $products = [])
  {
    $query = $this->pdo->query("SELECT * FROM $this->table");

    if (!$query->rowCount()) {
      $sql = "INSERT INTO $this->table(name, price, count) VALUES(:name, :price, :count)";
      $stmt = $this->pdo->prepare($sql);

      if (!count($products)) {
        $products = $this->products;
      }

      foreach ($products as $product) {
        $stmt->bindValue(':name', $product['name']);
        $stmt->bindValue(':price', $product['price']);
        $stmt->bindValue(':count', $product['count']);
        $stmt->execute();
      }
    }
  }

  public function insert(array $tableColumns, array $values): array
  {
    $result = null;

    $sql = "INSERT INTO $this->table(" . implode(',', $tableColumns) . ") VALUES(?,?,?)";
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
    $sql = "UPDATE $this->table SET name=:name, price=:price, count=:count WHERE id=:id";
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