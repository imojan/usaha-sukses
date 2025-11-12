<?php
$pageTitle = 'Detail Produk — Usaha Sukses';
require __DIR__.'/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h4 mb-0">Detail Produk</h1>
  <a href="<?= base_url('index.php?page=products') ?>" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <table class=" table table-borderless table-border table-striped mb-0">
      <tr>
        <th style="width: 150px;">ID Produk</th>
        <td><?= (int)$product['id'] ?></td>
      </tr>
      <tr>
        <th>Nama Produk</th>
        <td><?= htmlspecialchars($product['name']) ?></td>
      </tr>
      <tr>
        <th>Harga</th>
        <td>Rp <?= number_format((int)$product['price'], 0, ',', '.') ?></td>
      </tr>
      <tr>
        <th>Stok</th>
        <td><?= (int)$product['stock'] ?></td>
      </tr>
      <tr>
        <th>Dibuat</th>
        <td><?= htmlspecialchars($product['created_at']) ?></td>
      </tr>
    </table>
  </div>
</div>

<?php require __DIR__.'/../layouts/footer.php'; ?>
