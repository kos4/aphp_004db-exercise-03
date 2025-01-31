<?php

use Netology\Client;
use Netology\Order;
use Netology\OrderProduct;
use Netology\Product;
use Netology\Shop;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoloader.php';

$shop = new Shop();
/*$res = $shop->insert(['name', 'address'], [
  ['Test2', 'ул. Ленина, 123'],
  ['Test3', 'ул. Ленина, 124'],
]);
print_r($res);*/
//print_r($shop->update(6, ['name' => 'Test6', 'address' => 'ул. Ленина, 22']));
//print_r($shop->find(1));
//var_dump($shop->delete(6));

$product = new Product();
/*$res = $product->insert(['name', 'price', 'count', 'shop_id'], [
  ['Майонез', 50, 100, 1],
  ['Морковь', 10, 1000, 2],
]);
print_r($res);*/
//print_r($product->update(6, ['name' => 'Морковь', 'price' => '11', 'count' => 500, 'shop_id' => 3]));
//print_r($product->find(1));
//var_dump($product->delete(6));

$client = new Client();
/*$res = $client->insert(['name', 'phone'], [
  ['Test2', '89112223343'],
  ['Test3', '89112223342'],
]);
print_r($res);*/
//print_r($client->update(6, ['name' => 'Test6', 'phone' => '89663334412']));
//print_r($client->find(1));
//var_dump($client->delete(6));

$order = new Order();
/*$res = $order->insert(['shop_id', 'client_id'], [
  [1, 2],
  [1, 2],
]);
print_r($res);*/
//print_r($order->update(6, ['shop_id' => 2, 'client_id' => 3]));
//print_r($order->find(1));
//var_dump($order->delete(6));

$orderProduct = new OrderProduct();
/*$res = $orderProduct->insert(['order_id', 'product_id', 'price', 'quantity'], [
  [7, 1, 111, 1],
  [7, 2, 112, 11],
]);
print_r($res);*/
//print_r($orderProduct->update(6, ['order_id' => 5, 'product_id' => 1, 'price' => 111, 'quantity' => 2]));
//print_r($orderProduct->find(1));
//var_dump($orderProduct->delete(6));

