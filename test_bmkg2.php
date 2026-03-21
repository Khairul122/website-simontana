<?php
session_start();
require 'config/koneksi.php';
require 'services/BmkgService.php';
$s = new BmkgService();
$res = $s->getSummary();
file_put_contents('output_bmkg.txt', json_encode($res, JSON_PRETTY_PRINT));
echo "Done";
