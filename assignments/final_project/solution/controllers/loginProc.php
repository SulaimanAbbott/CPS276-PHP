<?php
require_once 'classes/Pdo_methods.php';

$acknowledgment = "<p></p>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pdo = new PdoMethods();
  $sql = "SELECT * FROM admins WHERE email=:email";
  $bindings = [[':email', $_POST['email'], 'str']];
  $result = $pdo->selectBinded($sql, $bindings);

  if ($result === 'error' || count($result) == 0) {
    $acknowledgment = '<p style="color:red">Invalid login</p>';
  } else {
    $admin = $result[0];
    if (password_verify($_POST['password'], $admin['password'])) {
      session_regenerate_id(true); // Prevent session fixation
      $_SESSION['name'] = $admin['first_name'] . ' ' . $admin['last_name'];
      $_SESSION['status'] = $admin['status'];
      header("Location: index.php?page=welcome");
      exit;
    } else {
      $acknowledgment = '<p style="color:red">Invalid login</p>';
    }
  }
}
?>