<?php
session_start();
$_SESSION['admin_id'] = 1;
$_SESSION['username'] = 'admin';
header('Location: pages/index.php');
exit;
