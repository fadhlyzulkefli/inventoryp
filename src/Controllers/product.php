<?php

use Slim\Http\Request; //namespace
use Slim\Http\Response; //namespace

//include productProc.php file
include __DIR__ . '/../Controllers/productProc.php';

//read table products
$app->get('/product', function (Request $request, Response $response, array $arg){
  return $this->response->withJson(array('data' => 'success'), 200);
});

//request table products by condition
$app->get('/product/[{id}]', function ($request, $response,$args) {
    $productId = $args['id'];
    if (!is_numeric($productId)) {
        return $this->response->withJson(array('error' => 'numeric parameter required'), 422);
    }
    $data = getProduct($this->db, $productId);
    if (empty($data)) {
        return $this->response->withJson(array('error' => 'no data'), 404);
    }
    return $this->response->withJson(array('data' => $data), 200);
});

//Code to apply method POST

$app->post('/product/add', function ($request, $response, $args) {
  $form_data = $request->getParsedBody();
  $data = createProduct($this->db, $form_data);
  if ($data <= 0) {
    return $this->response->withJson(array('error' => 'add data fail'), 500);
  }
  return $this->response->withJson(array('add data' => 'success'), 201);
  }
);

//Code to apply method PUT
$app->put('/product/update/[{id}]', function ($request, $response, $args) {
  $productId = $args['id'];
  if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric parameter required'), 422);
    }
  $form_data = $request->getParsedBody();
  $data = updateProduct($this->db, $productId, $form_data);
  if ($data <= 0) {
    return $this->response->withJson(array('error' => 'update data fail'), 500);
    }
  return $this->response->withJson(array('update data' => 'success'), 201);
  }
);

//Code to apply method DELETE
$app->delete('/product/del/[{id}]', function ($request, $response, $args) {
  $productId = $args['id'];
  $data = deleteProduct($this->db, $productId);
  if (!is_numeric($productId)) {
    return $this->response->withJson(array('error' => 'numeric parameter required'), 422);
    }
  $data = deleteProduct($this->db, $productId);
  if (empty($data)) {
    return $this->response->withJson(array('delete' => 'success'), 200);
    }
  return $this->response->withJson(array('delete' => 'fail'), 404);
  }
);
