<?php require_once __DIR__.'/../../functions.php'; ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($pageTitle ?? 'Usaha Sukses') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/ikon-us.png') ?>">

  <!-- Google Fonts: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom style -->
  <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
  
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-white border-bottom shadow-sm">
  <div class="container">
    <!-- LOGO + NAMA -->
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= base_url('index.php') ?>">
      <img src="<?= base_url('assets/img/usaha.png') ?>" alt="Logo Usaha Sukses" height="60" style="border-radius: 10px;">
    </a>

    <!-- TOMBOL RESPONSIVE -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    

    <!-- NAV MENU -->
    <div id="navMain" class="collapse navbar-collapse">
       
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php?page=products') ?>">Produk</a></li>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4">
  <?php flash_show(); ?>
