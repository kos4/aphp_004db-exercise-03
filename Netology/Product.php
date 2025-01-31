<?php

namespace Netology;

use Netology\ConnectDB;

class Product extends ConnectDB
{
  protected string $table = 'product';
  protected array $products = [
    [
      'name' => 'Хлеб',
      'price' => 50,
      'count' => 100,
      'shop_id' => 1,
    ],
    [
      'name' => 'Молоко',
      'price' => 100,
      'count' => 50,
      'shop_id' => 2,
    ],
    [
      'name' => 'Сыр',
      'price' => 150,
      'count' => 30,
      'shop_id' => 3,
    ],
    [
      'name' => 'Кефир',
      'price' => 90,
      'count' => 40,
      'shop_id' => 4,
    ],
    [
      'name' => 'Сметана',
      'price' => 50,
      'count' => 10,
      'shop_id' => 5,
    ],
  ];

  public function createTable(): \PDOStatement|false
  {
    $sql = "CREATE TABLE IF NOT EXISTS $this->table (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name CHAR(255),
      price FLOAT DEFAULT 0,
      count INT DEFAULT 0,
      shop_id INT,
      CONSTRAINT product_shop_fk FOREIGN KEY (shop_id) REFERENCES shop (id) ON DELETE CASCADE
    )";
    return $this->pdo->query($sql);
  }

  public function insertTestData(array $products = []): void
  {
    $query = $this->pdo->query("SELECT * FROM $this->table");

    if (!$query->rowCount()) {
      $sql = "INSERT INTO $this->table(name, price, count, shop_id) VALUES(:name, :price, :count, :shop_id)";
      $stmt = $this->pdo->prepare($sql);

      if (!count($products)) {
        $products = $this->products;
      }

      foreach ($products as $product) {
        $stmt->bindValue(':name', $product['name']);
        $stmt->bindValue(':price', $product['price']);
        $stmt->bindValue(':count', $product['count']);
        $stmt->bindValue(':shop_id', $product['shop_id']);
        $stmt->execute();
      }
    }
  }

  public function insert(array $tableColumns, array $values): array
  {
    $result = null;

    $sql = "INSERT INTO $this->table(" . implode(',', $tableColumns) . ") VALUES(?,?,?,?)";
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
    $sql = "UPDATE $this->table SET name=:name, price=:price, count=:count, shop_id=:shop_id WHERE id=:id";
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