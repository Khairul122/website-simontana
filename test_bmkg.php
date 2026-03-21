<?php
session_start();
require 'config/koneksi.php';
require 'services/BmkgService.php';
$s = new BmkgService();
echo json_encode($s->getSummary(), JSON_PRETTY_PRINT);
