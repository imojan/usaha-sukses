<?php
$isEdit = isset($product['id']);
$pageTitle = ($isEdit ? 'Edit' : 'Tambah') . ' Produk — Usaha Sukses';
require __DIR__.'/../layouts/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="h4 mb-0"><?= $isEdit ? 'Edit Produk' : 'Tambah Produk' ?></h1>
  <a href="<?= base_url('index.php?page=products') ?>" class="btn btn-outline-primary">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>

<form method="post" action="<?= base_url('index.php?page=products&action='.($isEdit?'update&id='.$product['id']:'store')) ?>">
  <!-- Kartu form utama -->
  <div class="soft-card p-4 mb-3">
    <div class="section-title mb-1">Informasi Produk</div>
    <div class="help-text mb-3">Lengkapi data produk baru dibawah yang akan disimpan.</div>

    <div class="row g-3 input-compact">
      <div class="col-12 col-md-6">
        <label class="form-label">Nama Produk</label>
        <input
          type="text"
          name="name"
          class="form-control soft-input"
          required
          value="<?= htmlspecialchars($product['name'] ?? '') ?>"
          placeholder="Contoh: Sabun Mandi Usaha">
      </div>

      <div class="col-12 col-md-3">
        <label class="form-label">Harga (Rp)</label>
        <div class="input-group">
          <span class="input-group-text soft-input " style="border-radius:10px 10px 10px 10px;background:#f7f9fb;border:1px solid #e5e7eb;">Rp</span>
          <input
            type="number"
            name="price"
            class="form-control soft-input"
            min="0"
            required
            value="<?= (int)($product['price'] ?? 0) ?>"
            placeholder="0">
        </div>
      </div>

      <div class="col-12 col-md-3">
        <label class="form-label">Stok</label>
        <input
          type="number"
          name="stock"
          class="form-control soft-input"
          min="0"
          required
          value="<?= (int)($product['stock'] ?? 0) ?>"
          placeholder="0">
      </div>
    </div>

    <div class="card-divider"></div>

    <div class="d-flex gap-2 mt-3">
      <button class="btn btn-success"><?= $isEdit ? 'Simpan Perubahan' : 'Simpan' ?></button>
      <a class="btn btn-light border" href="<?= base_url('index.php?page=products') ?>">Batal</a>
    </div>
  </div>
</form>

<?php require __DIR__.'/../layouts/footer.php'; ?>
