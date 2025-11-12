<?php
// controllers/products.php
require_once __DIR__.'/../functions.php';
require_once __DIR__.'/../models/FunctionProduct.php';

$model = new FunctionProduct($mysqli);

$action = $_GET['action'] ?? 'index';
$id     = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? '');
  $price = (int) ($_POST['price'] ?? 0);
  $stock = (int) ($_POST['stock'] ?? 0);

  if ($name === '') {
    flash_set('error','Nama produk wajib diisi.');
    redirect('index.php?page=products&action=create');
  }

  if ($model->create($name,$price,$stock)) {
    flash_set('success','Produk berhasil ditambahkan.');
  } else {
    flash_set('error','Gagal menambah produk.');
  }
  redirect('index.php?page=products');

} elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? '');
  $price = (int) ($_POST['price'] ?? 0);
  $stock = (int) ($_POST['stock'] ?? 0);

  if ($name === '') {
    flash_set('error','Nama produk wajib diisi.');
    redirect('index.php?page=products&action=edit&id='.$id);
  }

  if ($model->update($id,$name,$price,$stock)) {
    flash_set('success','Produk berhasil diperbarui.');
  } else {
    flash_set('error','Gagal memperbarui produk.');
  }
  redirect('index.php?page=products');

} elseif ($action === 'destroy' && $id) {
    if ($model->delete($id)) {
      flash_set('success','Produk berhasil dihapus.');
    } else {
      flash_set('error','Gagal menghapus produk.');
    }
    redirect('index.php?page=products');
    
  } elseif ($action === 'show' && $id) {
    $product = $model->find($id);
    if (!$product) {
      flash_set('error','Produk tidak ditemukan.');
      redirect('index.php?page=products');
    }
    require __DIR__.'/../views/products/show.php';

} else {
  // Render view
  $keyword = trim($_GET['q'] ?? '');

  if ($action === 'create' || ($action === 'edit' && $id)) {
    // form create/edit (tetap sama)
    $product = $action === 'edit'
      ? $model->find($id)
      : ['name'=>'','price'=>0,'stock'=>0];

    require __DIR__.'/../views/products/form.php';

  } else {
    // ====== LISTING DENGAN PAGINATION + SORT ======
    $keyword = trim($_GET['q'] ?? '');
    $allowedPer = [5,10,25,50,100];
    $per = (int)($_GET['per'] ?? 10);
    if (!in_array($per, $allowedPer, true)) $per = 10;

    $page = (int)($_GET['p'] ?? 1);
    if ($page < 1) $page = 1;

    // --- baca sort (default: latest)
    $sort = $_GET['sort'] ?? 'latest';
    // amankan nilai sort agar hanya salah satu dari daftar ini
    $allowedSort = ['latest','name_asc','name_desc','price_asc','price_desc','stock_asc','stock_desc'];
    if (!in_array($sort, $allowedSort, true)) $sort = 'latest';

    // hitung total + halaman
    $total = $model->countAll($keyword);
    $pages = max(1, (int)ceil($total / $per));
    if ($page > $pages) $page = $pages;

    // ambil data halaman ini (bawa 'sort')
    $offset   = ($page - 1) * $per;
    $products = $model->page($keyword, $offset, $per, $sort);

    // untuk view
    $pagination = [
      'total'      => $total,
      'per'        => $per,
      'page'       => $page,
      'pages'      => $pages,
      'offset'     => $offset,
      'allowedPer' => $allowedPer,
      'q'          => $keyword,
      'sort'       => $sort,
      'allowedSort'=> $allowedSort,
    ];
    require __DIR__.'/../views/products/index.php';

  }
}