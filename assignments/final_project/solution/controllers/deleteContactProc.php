<?php
require_once 'classes/Pdo_methods.php';
$pdo = new PdoMethods();

$msg = "<p>&nbsp;</p>";
$output = "";
$deleted = false;

if (isset($_POST['delete'])) {
  if (isset($_POST['chkbx'])) {
    foreach ($_POST['chkbx'] as $id) {
      $sql = "DELETE FROM contacts WHERE id=:id";
      $bindings = [[':id', $id, 'int']];
      $result = $pdo->otherBinded($sql, $bindings);

      if ($result === 'error') {
        $msg = "<p style='color:red'>Could not delete the contacts</p>";
        break;
      } else {
        $deleted = true;
      }
    }
    if ($deleted) {
      $msg = "<p style='color:green'>Contact(s) deleted</p>";
    }
  }
}

$sql = "SELECT * FROM contacts";
$records = $pdo->selectNotBinded($sql);

if (!$records || count($records) === 0) {
  $msg = "<p>There are no records to display</p>";
}
?>