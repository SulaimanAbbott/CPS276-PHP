<?php
//check for valid session variables
if (!isset($_SESSION['status'])) {
  header("Location: index.php?page=login");
  exit;
}
if (in_array($_GET['page'], ['addAdmin','deleteAdmins']) && $_SESSION['status'] !== 'admin') {
  header("Location: index.php?page=login");
  exit;
}
?>