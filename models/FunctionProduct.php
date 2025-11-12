<?php
// models/FunctionProduct.php
require_once __DIR__ . '/../config.php';

class FunctionProduct {
  private mysqli $db;
  public function __construct(mysqli $db) { $this->db = $db; }

  public function all(string $keyword = ''): array {
    if ($keyword !== '') {
      $sql = "SELECT * FROM products WHERE name LIKE ? ORDER BY id DESC";
      $stmt = $this->db->prepare($sql);
      $like = '%'.$keyword.'%';
      $stmt->bind_param('s', $like);
    } else {
      $sql = "SELECT * FROM products ORDER BY id DESC";
      $stmt = $this->db->prepare($sql);
    }
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
  }

  public function countAll(string $keyword = ''): int {
  if ($keyword !== '') {
    $sql = "SELECT COUNT(*) AS c FROM products WHERE name LIKE ?";
    $stmt = $this->db->prepare($sql);
    $like = '%'.$keyword.'%';
    $stmt->bind_param('s', $like);
  } else {
    $sql = "SELECT COUNT(*) AS c FROM products";
    $stmt = $this->db->prepare($sql);
  }
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();
  return (int)($res['c'] ?? 0);
}

  public function find(int $id): ?array {
    $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res ?: null;
  }

  public function create(string $name, int $price, int $stock): bool {
    $stmt = $this->db->prepare("INSERT INTO products(name, price, stock) VALUES(?,?,?)");
    $stmt->bind_param('sii', $name, $price, $stock);
    return $stmt->execute();
  }

  public function update(int $id, string $name, int $price, int $stock): bool {
    $stmt = $this->db->prepare("UPDATE products SET name=?, price=?, stock=? WHERE id=?");
    $stmt->bind_param('siii', $name, $price, $stock, $id);
    return $stmt->execute();
  }

  public function delete(int $id): bool {
    $stmt = $this->db->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param('i', $id);
    return $stmt->execute();
  }

  // Tambah di dalam class FunctionProduct
  private function resolveSort(string $sort): array {
    // whitelist: kolom & arah yang diizinkan
    switch ($sort) {
      case 'name_asc':   return ['name',  'ASC'];
      case 'name_desc':  return ['name',  'DESC'];
      case 'price_asc':  return ['price', 'ASC'];
      case 'price_desc': return ['price', 'DESC'];
      case 'stock_asc':  return ['stock', 'ASC'];
      case 'stock_desc': return ['stock', 'DESC'];
      case 'latest':     return ['id',    'DESC']; // terbaru ditambahkan (ID tertinggi)
      default:           return ['id',    'DESC'];
    }
  }

  /**
   * Ambil daftar produk versi halaman (pagination + sorting)
   */
  public function page(string $keyword = '', int $offset = 0, int $limit = 10, string $sort = 'latest'): array {
    [$col, $dir] = $this->resolveSort($sort); // aman karena di-whitelist

    if ($keyword !== '') {
      $sql  = "SELECT * FROM products
              WHERE name LIKE ?
              ORDER BY $col $dir
              LIMIT ?, ?";
      $stmt = $this->db->prepare($sql);
      $like = '%'.$keyword.'%';
      $stmt->bind_param('sii', $like, $offset, $limit);
    } else {
      $sql  = "SELECT * FROM products
              ORDER BY $col $dir
              LIMIT ?, ?";
      $stmt = $this->db->prepare($sql);
      $stmt->bind_param('ii', $offset, $limit);
    }

    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

}

