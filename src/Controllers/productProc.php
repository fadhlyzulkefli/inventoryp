<?php

//get all products
function getAllProduct($db)
{
$sql = 'Select p.name, p.description, p.price, c.name as category from 
products p ';
$sql .='Inner Join categories c on p.category_id = c.id';
$stmt = $db->prepare ($sql);
$stmt ->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//get product by id
function getProduct($db, $productId)
{
    $sql = 'Select p.name, p.description, p.price, c.name as category from products p ';
    $sql .= 'Inner Join categories c on p.category_id = c.id ';
    $sql .= 'where p.id = :id';
    $stmt = $db->prepare ($sql);
    $id = (int) $productId;
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//add new product
function createProduct($db, $form_data) {
    $sql = 'Insert Into products (name, description, price, category_id, created)';
    $sql .= 'values (:name, :description, :price, :category_id, :created)';
    $stmt = $db->prepare ($sql);
    $stmt->bindParam(':name', $form_data['name']);
    $stmt->bindParam(':description', $form_data['description']);
    $stmt->bindParam(':price', ($form_data['price']));
    $stmt->bindParam(':category_id', ($form_data['category_id']));
    $stmt->bindParam(':created', $form_data['created']);
    $stmt->execute();
    return $db->lastInsertID();//insert last number.. continue
    }

//update existing record - insert ID by url
function updateProduct($db, $productId, $form_data) {
    $sql = "UPDATE products SET name=:name, description=:description, price=:price, category_id=:category_id, created=:created WHERE id=:id";
    
    // echo $sql;
    $stmt = $db->prepare ($sql);
    $id = (int)$productId;
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $form_data['name']);
    $stmt->bindParam(':description', $form_data['description']);
    $stmt->bindParam(':price', $form_data['price']);
    $stmt->bindParam(':category_id', $form_data['category_id']);
    $stmt->bindParam(':created', $form_data['created']);
    $stmt->execute();
    return $stmt->rowCount();
    }
//delete existing record
function deleteProduct($db, $productId) {
    $sql = 'DELETE FROM products WHERE id = :id';
    $stmt = $db->prepare ($sql);
    $id = (int) $productId;
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }