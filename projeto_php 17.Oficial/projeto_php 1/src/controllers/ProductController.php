<?php
//inclui o arquivo de modelo para poder usar a classe Product.
//isso permite o uso de metodos como getAll, getById create, update e delete para manipular dados do banco de dados.
require_once __DIR__ . '/../models/Product.php';

//declaraçao da classe prodcutcontroller. classe responsavl por controlar as operaçoes relacionada aos produtos
class ProductController 
{

//metodo que retorna a lista de todos os produtos
    public function listProducts()
{
    //chama o metodo estatico getAll da classe product para obter todos os produtos
    return Product::getAll();

}


public function viewProduct($id)
{
    return Product:: getbyId($id);

}

public function createProduct($data)
{
    Product::create($data);
}

public function editProduct($id, $data)
{
    Product:: update($id, $data);
}

public function deleteProduct($id) {
    Product::delete($id);
}

}