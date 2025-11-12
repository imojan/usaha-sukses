<?php
require_once __DIR__.'/functions.php';

$page = $_GET['page'] ?? 'products';

switch ($page) {
  case 'products':
  default:
    require __DIR__.'/controllers/products.php';
    break;
}
