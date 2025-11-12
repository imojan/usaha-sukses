<?php
$pageTitle='Produk — Usaha Sukses';
require __DIR__.'/../layouts/header.php';

/** helper link page */
function page_link($p, $per, $q, $sort) {
  $params = ['page'=>'products','p'=>$p,'per'=>$per,'sort'=>$sort];
  if ($q !== '') $params['q'] = $q;
  return base_url('index.php?'.http_build_query($params));
}


$q      = htmlspecialchars($pagination['q'] ?? '', ENT_QUOTES, 'UTF-8');
$total  = (int)($pagination['total'] ?? 0);
$per    = (int)($pagination['per'] ?? 10);
$page   = (int)($pagination['page'] ?? 1);
$pages  = (int)($pagination['pages'] ?? 1);
$allowedPer = $pagination['allowedPer'] ?? [5,10,25,50,100];
$from   = $total ? ($pagination['offset'] + 1) : 0;
$to     = $total ? min($pagination['offset'] + $per, $total) : 0;
$sort   = htmlspecialchars($pagination['sort'] ?? 'latest', ENT_QUOTES, 'UTF-8');
?>

<!-- Top toolbar: meta + add button -->
<div class="d-flex align-items-center justify-content-between mb-3">
  <h3 class="h4 mb-0 text-dark">Daftar <span class="text-warning">Produk</span></h3>
  <div class="text-muted d-flex flex-wrap align-items-center gap-3 ms-auto">
    Semua Produk: <span class="fw-semibold text-dark"><?= $total ?></span>
  </div>
</div>

<!-- Filters row (compact, side-by-side) -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">

  <a href="<?= base_url('index.php?page=products&action=create') ?>"
     class="btn btn-success rounded-pill">
    <i class="bi bi-plus-lg me-2"></i> Tambah Produk Baru
  </a>
  <!-- kanan: search + sort berdampingan -->
  <div class="d-flex flex-wrap align-items-center gap-3 ms-auto">

    <!-- Search -->
    <form class="searchbar" method="get" action="<?= base_url('index.php') ?>">
      <input type="hidden" name="page" value="products">
      <input type="hidden" name="sort" value="<?= $sort ?>">
      <div class="input-group input-group-sm">
        <span class="input-group-text"><i class="bi bi-search"></i></span>
        <input type="text" name="q" class="form-control" placeholder="Cari produk..." value="<?= $q ?>">
        <button class="btn btn-light btn-search" type="submit">Search</button>
      </div>
    </form>

    <!-- Sort by -->
    <form class="sort-select" method="get" action="<?= base_url('index.php') ?>">
      <input type="hidden" name="page" value="products">
      <input type="hidden" name="q" value="<?= $q ?>">
      <input type="hidden" name="p" value="1">
      <div class="input-group input-group-sm">
        <span class="input-group-text" > <i class="bi bi-filter"> </i></span>
        <select name="sort" class="form-select" onchange="this.form.submit()">
          <option value="latest"     <?= $sort==='latest'     ? 'selected':'' ?>>Terbaru ditambahkan</option>
          <option value="name_asc"   <?= $sort==='name_asc'   ? 'selected':'' ?>>Nama A–Z</option>
          <option value="name_desc"  <?= $sort==='name_desc'  ? 'selected':'' ?>>Nama Z–A</option>
          <option value="price_asc"  <?= $sort==='price_asc'  ? 'selected':'' ?>>Harga Termurah</option>
          <option value="price_desc" <?= $sort==='price_desc' ? 'selected':'' ?>>Harga Termahal</option>
          <option value="stock_asc"  <?= $sort==='stock_asc'  ? 'selected':'' ?>>Stok Terendah</option>
          <option value="stock_desc" <?= $sort==='stock_desc' ? 'selected':'' ?>>Stok Terbanyak</option>
        </select>
      </div>
    </form>

  </div>
</div>



<!-- Table -->
<div class="border rounded-3 overflow-hidden bg-white">
  <table class="table table- table-striped align-middle mb-0">
    <thead>
      <tr>
        <th style="width:56px;">No</th>
        <th>Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th style="width:160px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($products)): ?>
        <tr>
          <td colspan="5" class="text-center text-muted py-4">Belum ada data produk.</td>
        </tr>
      <?php else: foreach ($products as $i => $p): ?>
        <tr>
          <td class="text-center"><?= $pagination['offset'] + $i + 1 ?></td>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td class="text-center">Rp <?= number_format((int)$p['price'], 0, ',', '.') ?></td>
          <td class="text-center"><?= (int)$p['stock'] ?></td>
          <td class="text-center">
            <div>
              <a href="<?= base_url('index.php?page=products&action=show&id='.$p['id']) ?>"
                 class="btn btn-sm btn-outline-primary">
                <i class="bi bi-eye"></i>
              </a>
            <div class="btn-group">
              <a href="<?= base_url('index.php?page=products&action=edit&id='.$p['id']) ?>"
                 class="btn btn-sm btn-outline-success">
                <i class="bi bi-pencil"></i>
              </a>
            </div>
            <div class="btn-group">
              <a href="<?= base_url('index.php?page=products&action=destroy&id='.$p['id']) ?>"
                 class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('Yakin hapus produk ini?')">
                <i class="bi bi-trash"></i>
              </a>
            </div>
          </td>
        </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>


 <!-- Footer: range info + pagination -->
<div class="card shadow-sm border-0">
  <div class="card-body p-0">
    <!-- Footer baris 1: range (kiri) + pagination (kanan) -->
    <div class="px-3 py-2 d-flex flex-wrap align-items-center justify-content-between gap-2 border-top bg-white">
      <div class="text-muted small"><?= $from ?>–<?= $to ?> of <?= $total ?></div>
      <nav aria-label="Pagination" class="ms-auto">
        <ul class="pagination pagination-sm mb-0">
        <li class="page-item <?= $page<=1?'disabled':'' ?>">
            <a class="page-link" href="<?= page_link(max(1,$page-1), $per, $pagination['q'], $sort) ?>">
              <i class="bi bi-chevron-left"></i>
            </a>
          </li>

          <?php
          $start = max(1, $page-2);
          $end   = min($pages, $page+2);

          if ($start > 1) {
            echo '<li class="page-item"><a class="page-link" href="'.page_link(1,$per,$pagination['q'],$sort).'">1</a></li>';
            if ($start > 2) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
          }

          for ($i = $start; $i <= $end; $i++) {
            $active = $i===$page ? 'active' : '';
            echo '<li class="page-item '.$active.'"><a class="page-link" href="'.page_link($i,$per,$pagination['q'],$sort).'">'.$i.'</a></li>';
          }

          if ($end < $pages) {
            if ($end < $pages-1) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
            echo '<li class="page-item"><a class="page-link" href="'.page_link($pages,$per,$pagination['q'],$sort).'">'.$pages.'</a></li>';
          }
          ?>

          <li class="page-item <?= $page>=$pages?'disabled':'' ?>">
            <!-- penting: sertakan $sort -->
            <a class="page-link" href="<?= page_link(min($pages,$page+1), $per, $pagination['q'], $sort) ?>">
              <i class="bi bi-chevron-right"></i>
            </a>
          </li>
        </ul>
      </nav>
    </div>

    <!-- Footer baris 2: rows per page (tengah) -->
    <div class="px-2 py-2 border-top bg-light">
      <form method="get" action="<?= base_url('index.php') ?>" id="perForm"
            class="d-flex justify-content-center align-items-center gap-2">
        <input type="hidden" name="page" value="products">
        <input type="hidden" name="q" value="<?= $q ?>">
        <input type="hidden" name="sort" value="<?= $sort ?>">
        <input type="hidden" name="p" value="1">
        <label class="text-muted mb-0">Rows per page</label>
        <select name="per" class="form-select form-select-sm" style="max-width:60px"
                onchange="document.getElementById('perForm').submit()">
          <?php foreach ($allowedPer as $opt): ?>
            <option value="<?= $opt ?>" <?= $opt===$per ? 'selected':'' ?>><?= $opt ?></option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>

  </div>
</div>


</div>


<?php require __DIR__.'/../layouts/footer.php'; ?>
