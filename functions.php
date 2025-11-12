<?php
// functions.php
require_once __DIR__.'/config.php';

function base_url(string $path = ''): string {
  $prefix = rtrim(BASE_URL, '/');
  $path   = ltrim($path, '/');
  return $prefix . ($path ? "/$path" : '');
}

function redirect(string $to): void {
  header("Location: " . base_url($to));
  exit;
}

// Flash message sederhana pakai session
if (session_status() === PHP_SESSION_NONE) session_start();

function flash_set(string $type, string $message): void {
  $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
function flash_show(): void {
  if (!empty($_SESSION['flash'])) {
    $f = $_SESSION['flash'];
    $cls = $f['type'] === 'success' ? 'alert-success' : 'alert-danger';
    echo '<div class="alert '.$cls.' mt-3" role="alert">'.htmlspecialchars($f['message']).'</div>';
    unset($_SESSION['flash']);
  }
}
