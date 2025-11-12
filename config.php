<?php
const BASE_URL = '/usaha-sukses'; 

// Koneksi MySQLi (lokal XAMPP/MAMP/WAMP)
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = ''; // default XAMPP kosong
$dbName = 'usaha_sukses';

$mysqli = @new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
  die('Koneksi DB gagal: ' . $mysqli->connect_error);
}

// Saat pengembangan tampilkan error
error_reporting(E_ALL);
ini_set('display_errors', 1);



