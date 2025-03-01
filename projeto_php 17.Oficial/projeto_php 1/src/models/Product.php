<?php
// src/models/Product.php

require_once __DIR__ . '/../database/Connection.php';

class Product
{
    public static function getAll(): array
    {
        $db = Connection::getConnection();
        $stmt = $db->query('SELECT * FROM products');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id): mixed
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare(query: 'SELECT * FROM products WHERE id = :id');
        $stmt->execute(params: ['id' => $id]);
        return $stmt->fetch(mode: PDO::FETCH_ASSOC);
    }

    public static function create($data): void
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare(query: 'INSERT INTO products (name, description, price) 
        VALUES (:name, :description, :price)');
        $stmt->execute(params: [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price']
        ]);
    }

    public static function update($id, $data): void
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare(query: 'UPDATE products SET name = :name, 
        description = :description, price = :price WHERE id = :id');
        $stmt->execute(params: [
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price']
        ]);
    }

    public static function delete($id): void
    {
        $db = Connection::getConnection();
        $stmt = $db->prepare(query: 'DELETE FROM products WHERE id = :id');
        $stmt->execute(params: ['id' => $id]);
    }
}


