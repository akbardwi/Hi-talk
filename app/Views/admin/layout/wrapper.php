<?php 
$config = null;
$session = \Config\Services::session($config);
// Check session

// Gabungin ya semua bagian layout
include('head.php');
include('header-menu.php');
include('content.php');
include('footer.php');