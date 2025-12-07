<?php
function init(){
  $name = $_SESSION['name'] ?? 'Guest';
  $status = $_SESSION['status'] ?? '';

  $links = "<p>";
  $links .= "<a href='index.php?page=addContact'>Add Contact</a> &nbsp;&nbsp;&nbsp; ";
  $links .= "<a href='index.php?page=deleteContacts'>Delete Contact(s)</a> &nbsp;&nbsp;&nbsp; ";

  if ($status === 'admin') {
    $links .= "<a href='index.php?page=addAdmin'>Add Admin</a> &nbsp;&nbsp;&nbsp; ";
    $links .= "<a href='index.php?page=deleteAdmins'>Delete Admin(s)</a> &nbsp;&nbsp;&nbsp; ";
  }

  $links .= "<a href='logout.php'>Logout</a>";
  $links .= "</p>";

  return <<<HTML
  <div class="container mt-5">
    {$links}
    <h1>Welcome Page</h1>
    <p>Welcome {$name}</p>
  </div>
HTML;
}
?>